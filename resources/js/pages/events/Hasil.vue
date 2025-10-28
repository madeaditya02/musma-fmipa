<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Kegiatan } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
  kegiatan: Kegiatan
}>()

const totalSuara = props.kegiatan.kandidat!.reduce((acc, val) => acc + val.jumlah_suara, 0)
const kandidat = computed(() => {
  return props.kegiatan.kandidat?.map(calon => ({
    ...calon,
    jumlah_suara_persen: calon.jumlah_suara ? parseFloat((calon.jumlah_suara / totalSuara * 100).toFixed(2)) : 0
  }))
})
</script>
<template>

  <Head title="Hasil Pemilihan" />
  <AppLayout background="main">
    <div class="h-full mb-8">
      <div class="w-full flex justify-between items-start relative">
        <img src="/assets/corner-image-left.png" alt="" class="w-20 sm:w-40 lg:w-50">
        <img src="/assets/background-logo-dpm.png" alt="" class="h-20 sm:h-50 my-auto">
        <img src="/assets/corner-image-right.png" alt="" class="w-20 sm:w-40 lg:w-50">
        <h1
          class="text-xl sm:text-3xl lg:text-4xl font-bold text-center text-white uppercase absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2"
          style="text-shadow:
   -2px -2px 0 #A50000,  
    2px -2px 0 #A50000,
    -2px 2px 0 #A50000,
     2px 2px 0 #A50000;">{{ kegiatan && kegiatan.kandidat && kegiatan.kandidat.length > 0
      ? kegiatan.nama
      : "Tidak ada event pemilihan berlangsung" }}
        </h1>
      </div>

      <div v-if="kegiatan && kegiatan.kandidat && kegiatan.kandidat.length > 0">
        <div class="flex flex-wrap px-4">
          <div class="h-120 flex flex-col justify-between w-full sm:w-1/2" v-for="(calon, i) in kandidat"
            :key="calon.id"
            :class="(i + 1) == 3 ? '!w-fit mx-auto' : ((i + 1) % 2 == 0 ? 'items-center sm:items-start' : 'items-center sm:items-end sm:pr-8')">
            <div class="h-105 flex items-end gap-4"
              :class="(i + 1) % 2 == 0 ? 'sm:flex-row-reverse' : ((i + 1) == 3 ? 'sm:flex-row-reverse' : '')">
              <div class="h-80 flex flex-col justify-center"
                :class="(i + 1) == 3 ? 'text-start' : ((i + 1) % 2 == 1 ? 'text-end w-full' : 'w-full')">
                <h3 class="text-xl font-semibold">
                  {{ calon.mahasiswa![0].nama }}
                </h3>
                <small>{{ calon.mahasiswa![0].program_studi.nama }} {{
                  calon.mahasiswa![0].angkatan.toString().substring(2, 4) }}</small>
              </div>
              <div class="h-full overflow-hidden rounded-b-full flex flex-col justify-end w-50 shrink-0">
                <div
                  class="h-80 w-full mt-auto rounded-full bg-linear-to-b from-[#F5791A] to-[#B42323] flex flex-col justify-end">
                  <img :src="`/storage/${calon.foto}`" class="h-auto mx-auto relative top-10" alt="">
                </div>
              </div>
              <div class="h-full w-12 flex flex-col gap-2 shrink-0 justify-end">
                <div class="font-semibold text-center w-full">{{ calon.jumlah_suara_persen }}%</div>
                <div class="rounded-t-2xl" :class="i % 2 == 0 ? 'bg-accent-red' : 'bg-accent-orange'"
                  :style="{ height: `${calon.jumlah_suara_persen}%` }">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center text-primary font-semibold text-lg">
          Total Suara : {{ totalSuara }}
        </div>
      </div>
    </div>
  </AppLayout>
</template>