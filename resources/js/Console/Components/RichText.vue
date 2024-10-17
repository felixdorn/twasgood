<script lang="ts" setup>
import {Editor, EditorContent, JSONContent, mergeAttributes, Node, VueNodeViewRenderer} from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import {Plugin, PluginKey} from '@tiptap/pm/state'
import LinkExtension from "@tiptap/extension-link";
import EmbedComponent from "@/Console/Components/editor/EmbedComponent.vue";
import {
    BoldIcon,
    EmbedIcon,
    ItalicIcon,
    LinkIcon,
    ListIcon,
    OrderedListIcon,
    QuoteIcon,
    RedoIcon,
    UndoIcon,
    H2Icon,
    H3Icon,
    H4Icon
} from "@/Console/Components/editor/icons"
import Button from "@/Console/Components/Button.vue";
import {Recipe} from "@/Console/types";

const props = defineProps<{
    content: JSONContent,
    recipes: Recipe[],
    buttonsClass?: string
}>()
const emit = defineEmits<{ (event: 'change', body: string): void }>()


const Embed = Node.create({
    name: 'embed',
    group: 'block',
    draggable: false,
    selectable: false,
    atom: false,

    addAttributes() {
        return {
            recipes: {
                default: []
            },
            type: {
                default: 'recipe-list'
            }
        }
    },

    parseHTML() {
        return [
            {
                tag: 'div[data-type="embed"]',
            }
        ]
    },


    renderHTML({HTMLAttributes}) {
        return ['div', mergeAttributes(HTMLAttributes, {'data-type': 'embed'})]
    },

    addNodeView() {
        return VueNodeViewRenderer(EmbedComponent)
    },
})

const editor = new Editor({
    content: props.content,
    dragDrop: false,
    extensions: [
        Embed,
        StarterKit.configure({
            codeBlock: false,
            heading: {
                levels: [2, 3, 4, 5]
            },
            dropcursor: false
        }),
        LinkExtension.configure({openOnClick: false}),
    ],

    autofocus: 'start',
    onUpdate: () => {
        emit('change', JSON.stringify(editor.getJSON()));
    }
})

editor.registerPlugin(new Plugin({
    key: new PluginKey('no-drag'),
    props: {
        handleDrop(_, __, ___, moved) {
            return !moved
        }
    }
}))

const insertEmbed = () => {
    editor.chain().focus().insertContent({
        type: 'embed',
        attrs: {
            recipes: [],
            type: 'recipe-list'
        }
    }).run()
}

const addLink = () => {
    const previousUrl = editor.getAttributes('link').href
    const url = window.prompt('URL', previousUrl)

    // cancelled
    if (url === null) {
        return
    }

    // empty
    if (url === '') {
        editor.chain().focus().extendMarkRange('link').unsetLink().run()

        return
    }

    // update link
    editor.chain().focus().extendMarkRange('link').setLink({href: url}).run()
}
</script>
<template>
    <div class="flex justify-between bg-white py-3 px-4" :class="buttonsClass">
        <div class="flex items-center space-x-4">
            <button :class="[editor.isActive('bold') ? 'bg-gray-100' : '']"
                    class="text-gray-700 p-2 rounded-xl flex items-center justify-center border hover:bg-gray-50"
                    @click="editor.chain().focus().toggleBold().run()">
                <BoldIcon class="w-5 h-5"/>
            </button>
            <button :class="[editor.isActive('italic') ? 'bg-gray-100' : '']"
                    class="text-gray-700 p-2 rounded-xl flex items-center justify-center border hover:bg-gray-50"
                    @click="editor.chain().focus().toggleItalic().run()">
                <ItalicIcon class="w-5 h-5"/>
            </button>
            <button :class="[editor.isActive('blockquote') ? 'bg-gray-100' : '']"
                    class="text-gray-700 p-2 rounded-xl flex items-center justify-center border hover:bg-gray-50"
                    @click="editor.chain().focus().toggleBlockquote().run()">
                <QuoteIcon class="w-5 h-5"/>
            </button>
            <button :class="[editor.isActive('bulletList') ? 'bg-gray-100' : '']"
                    class="text-gray-700 p-2 rounded-xl flex items-center justify-center border hover:bg-gray-50"
                    @click="editor.chain().focus().toggleBulletList().run()">
                <ListIcon class="w-5 h-5"/>
            </button>
            <button :class="[editor.isActive('orderedList') ? 'bg-gray-100' : '']"
                    class="text-gray-700 p-2 rounded-xl flex items-center justify-center border hover:bg-gray-50"
                    @click="editor.chain().focus().toggleOrderedList().run()">
                <OrderedListIcon class="w-5 h-5"/>
            </button>

            <!-- headings -->
            <button
                v-for="level in [2, 3, 4]"
                :key="level"
                :class="[editor.isActive('heading', {level}) ? 'bg-gray-100' : '']"
                class="text-gray-700 p-2 rounded-xl flex items-center justify-center border hover:bg-gray-50"
                @click="editor.chain().focus().toggleHeading({level}).run()">
                <component :is="{
                    2: H2Icon,
                    3: H3Icon,
                    4: H4Icon,
                }[level]" class="w-5 h-5"/>
            </button>

            <button
                :class="[editor.state.selection.empty ? 'opacity-25 text-gray-500 cursor-not-allowed': 'bg-gray-100']"
                :disabled="editor.state.selection.empty"
                class="text-gray-700 p-2 rounded-xl flex items-center justify-center border hover:bg-gray-50"
                @click="addLink">
                <LinkIcon class="w-5 h-5"/>
            </button>

            <button :class="[editor.isActive('embed') ? 'bg-gray-100' : '']"
                    class="text-gray-700 p-2 rounded-xl flex items-center justify-center border hover:bg-gray-50"
                    @click="insertEmbed">
                <EmbedIcon class="w-5 h-5"/>
            </button>
        </div>

        <div class="flex items-center space-x-2">
            <button
                :disabled="!editor.can('undo')"
                class="text-gray-700 p-2 rounded-xl flex items-center justify-center border border-transparent hover:bg-gray-50"
                @click="editor.chain().focus().undo().run()">
                <UndoIcon class="w-5 h-5"/>
            </button>

            <button
                :disabled="!editor.can('redo')"
                class="text-gray-700 p-2 rounded-xl flex items-center justify-center border border-transparent hover:bg-gray-50"
                @click="editor.chain().focus().redo().run()">
                <RedoIcon class="w-5 h-5"/>
            </button>
        </div>
    </div>
    <editor-content :editor="editor" class="prose max-w-full prose-headings:font-display bg-white" v-bind="$attrs"/>
</template>
<style>
.ProseMirror {
    @apply px-4 py-4 h-full;
}

.ProseMirror > * {
    margin-top: 0;
}

</style>
