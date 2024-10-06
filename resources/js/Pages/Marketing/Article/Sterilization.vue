<script lang="ts" setup>

import Marketing from "@/Layouts/Marketing.vue";
import {Head} from "@inertiajs/vue3";
</script>
<template>
  <Marketing>
    <Head title="Comment stériliser ses bocaux"/>
    <div class="w-full py-8 container mx-auto mt-6 px-8 lg:px-0">

      <img
          alt="Photo de la fondatrice du site"
          class="rounded-xl w-full h-auto lg:w-[900px] lg:h-[507px] object-top object-cover mx-auto"
          src="/loconsorve.webp"
      />

      <h1 class="text-4xl lg:text-6xl font-semibold my-12 mx-auto text-center">
        Comment stériliser ses bocaux
      </h1>

      <div class="prose mx-auto">

        <p>
          J'utilise depuis quelques années un autoclave, matériel canadien qui permet de faire ses conserves avec plus de
          sécurité quant au risque de botulisme, surtout pour les recettes qui mélangent plusieurs ingrédients ou qui
          n'ont pas assez d'acidité.
        </p>
        <p>
          Mais pour les fruits, les tomates, et même pendant longtemps pour tout le reste, je stérilise avec des bocaux
          à joints. Je prépare à l’avance des bocaux que je stérilise (dix minutes dans l’eau bouillante, en faisant
          attention au choc thermique) et je sors des joints NEUFS adaptés.
        </p>
        <p>
          Dès la fin de la cuisson, je remplis mes bocaux de la préparation toute chaude jusqu’au trait indiqué (en tout
          état de cause à deux cm au moins du haut du bocal). Je ferme.
        </p>
        <p>
          Je cale mes bocaux dans mon stérilisateur (très grande marmite) et je les recouvre d’eau à 5 cm au-dessus du
          dernier bocal.
        </p>
        <p>
          Je porte à ébullition (c’est long) et je compte le temps indiqué pour la stérilisation à partir de ce
          moment-là seulement. Il faut que ça ne cesse plus de bouillir. Je vérifie aussi, si c’est une stérilisation
          longue, qu’il reste suffisamment de liquide au-dessus des bocaux (sinon, hop, je refais le niveau avec de
          l’eau bouillante).
        </p>
        <p>
          Je laisse tiédir. Je sors les bocaux et les essuie. Lorsqu’ils sont froids, je teste la fermeture en
          déclipsant et en tirant légèrement sur le couvercle. S’il ne s’ouvre pas, c’est que la stérilisation a réussi.
          (Dans le cas contraire, il faut soit consommer le bocal soit le remettre à stériliser avec un nouveau joint).
        </p>
        <p>
          J’écris sur les bocaux la date et le contenu, et je remise.
        </p>
        <p>
          Au moment de consommer, je soulève d’abord le couvercle pour vérifier avant de tirer sur l’élastique. Si le
          couvercle s’ouvre sans avoir tiré sur l’élastique, c’est qu’il n’y avait plus le vide et il ne faut pas
          consommer le contenu.
        </p>
        <p>
          Pour toute question sur la stérilisation, je vous recommande vivement <a href="https://www.leparfait.fr/">le site Le parfait</a> et aussi un peu de
          bon sens et de prudence.
        </p>

        <div class="not-prose border-t my-8 pt-8">
          <div class="lg:flex">
            <img
                alt=""
                class="w-36 h-auto object-cover rounded-md object-left float-left lg:float-none mr-4 lg:mr-0"
                src="/moman-portrait.webp"
            >

            <div class="px-4">
              <h3 class="font-semibold text-xl">Charlotte Dorn</h3>
              <p class="max-w-lg text-base mt-1">
                Journaliste depuis 1996, prof de journalisme, citoyenne engagée, je partage des
                recettes et
                des
                guides
                pour
                faire plus soi-même et acheter moins tout fait. Le but : réduire son empreinte
                écologique et
                augmenter
                son
                autonomie.
              </p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </Marketing>
</template>
