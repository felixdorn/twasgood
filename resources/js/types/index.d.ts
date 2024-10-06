export const enum Season {
    Spring = 'spring',
    Summer = 'summer',
    Autumn = 'autumn',
    Winter = 'winter',
    All = 'all',
}

export const


    export
type Prerequisite = {
    id: number;

    details: string | null;
    quantity: string;

    optional: boolean;

    order: number;

    recipe_id: number;

    type: 'recipe' | 'ingredient'; // computed-
    prerequisite_type: 'recipe' | 'ingredient';
    prerequisite_id: number;

    created_at: string;
    updated_at: string;

    prerequisite: Recipe | Ingredient;
}

export type Asset = {
    id: number;

    recipe_id: number;

    path: string;
    alt: string;
    order: number;

    created_at: string;
    updated_at: string;
}

export type Ingredient = {
    id: number;

    name: string;
    type: IngredientType;

    contains_gluten: boolean;
    contains_dairy: boolean;

    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

export type Tag = {
    id: number;

    name: string;
    group_id: number;

    phantom: boolean;

    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

export type Category = {
    id: number;

    name: string;
    description: string;
    subtitle: string;
    hidden: boolean;

    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}

export type Task = {
    id: number;

    content: string;

    user_id: number;

    completed_at: string | null;
    created_at: string;
    updated_at: string;
}

export type Recipe = {
    id: number;
    category_id: number;

    title: string;
    short_title: string;
    season: Season;
    description: string;
    time_to_prepare: string;
    uses_sterilization: boolean;
    content: string;

    publishable: boolean;

    created_at: string;
    updated_at: string;
    published_at: string | null;
    deleted_at: string | null;
}

export type Diagnosis = {
    id: number;
    type: string;

    recipe_id: number;
    subresource_id: number | null;

    ignored_at: string | null;
    resolved_at: string | null;
}

export type Section = {
    id: number;

    title: string;
    description: string;
    force_hide: boolean;

    article_id: number;
}

export type Article = {
    id: number;

    title: string;

    banner: string | null;
    banner_thumbnail: string | null;
    banner_alt: string;
    description: string;
    content: string;

    created_at: string;
    updated_at: string;
    published_at: string | null;
    deleted_at: string | null;
}

export type Slug = {
    id: number;

    slug: string;
    sluggable_id: number;
    sluggable_type: string;

    created_at: string;
    updated_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
