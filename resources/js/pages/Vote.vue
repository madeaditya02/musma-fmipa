<script setup lang="ts">
import { Kandidat, Kegiatan } from '@/types';
import { Head, router } from "@inertiajs/vue3";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog'
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';

defineProps<{
  kegiatan: Kegiatan
}>()

const selectedKandidat = ref<Kandidat | null>(null);

function vote() {
  if (selectedKandidat.value) {
    router.post('', {
      kandidat: selectedKandidat.value?.id
    })
  }
}
</script>
<template>

  <Head title="Vote" />

  <AppLayout background="main">
    <!-- <div class="container mx-auto">
      <div class="md:w-6/12 mx-auto mt-12">
        <h1 class="text-4xl font-bold">{{ kegiatan.nama }}</h1>
        <div class="grid grid-cols-2 gap-8 mt-20">
          <Card v-for="calon in kegiatan.kandidat" :key="calon.id">
            <CardHeader>
              <CardTitle class="text-2xl">{{ calon.mahasiswa ? calon.mahasiswa[0].nama : '' }}</CardTitle>
              <CardDescription>Kabinet Lorem Ipsum</CardDescription>
            </CardHeader>
            <CardFooter>
              <Button @click="selectedKandidat = calon">Vote</Button>
            </CardFooter>
          </Card>
        </div>
      </div>
    </div> -->
    <div class="h-full">
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
     2px 2px 0 #A50000;">Pemilihan Ketua DPM FMIPA 2026
        </h1>
      </div>

      <div class="flex flex-wrap px-4">
        <div class="h-120 flex flex-col justify-between w-full sm:w-1/2" v-for="(kandidat, i) in kegiatan.kandidat"
          :key="kandidat.id"
          :class="(i + 1) == 3 ? '!w-fit mx-auto' : ((i + 1) % 2 == 0 ? 'items-center sm:items-start' : 'items-center sm:items-end sm:pr-8')">
          <div class="h-105 flex items-end gap-4"
            :class="(i + 1) % 2 == 0 ? 'flex-row-reverse' : ((i + 1) == 3 ? 'sm:flex-row-reverse' : '')">
            <div class="h-80 flex flex-col justify-center"
              :class="(i + 1) == 3 ? 'text-start' : ((i + 1) % 2 == 1 ? 'text-end w-full' : 'w-full')">
              <h3 class="text-xl font-semibold">
                {{ kandidat.mahasiswa![0].nama }}
              </h3>
              <small>{{ kandidat.mahasiswa![0].program_studi.nama }} {{
                kandidat.mahasiswa![0].angkatan.toString().substring(2, 4) }}</small>
            </div>
            <div class="h-full overflow-hidden rounded-b-full flex flex-col justify-end w-50 shrink-0">
              <div
                class="h-80 w-full mt-auto rounded-full bg-linear-to-b from-[#F5791A] to-[#B42323] flex flex-col justify-end">
                <img src="/assets/calon-2.png" class="h-auto mx-auto relative top-10" alt="">
              </div>
            </div>
          </div>
          <div class="flex"
            :class="(i + 1) == 3 ? 'justify-center' : ((i + 1) % 2 == 1 ? 'justify-end' : 'justify-start')">
            <Button class="w-50" @click="selectedKandidat = kandidat">Vote</Button>
          </div>
        </div>
        <!-- Calon 2 -->
        <!-- <div class="h-120 flex flex-col items-center sm:items-start justify-between w-full sm:w-1/2 sm:pl-8">
          <div class="h-105 flex flex-row-reverse items-end gap-4">
            <div class="h-80 flex flex-col justify-center w-full">
              <h3 class="text-xl font-semibold">
                Malin Kundang
              </h3>
              <small>Sastra Informatika 23</small>
            </div>
            <div class="h-full overflow-hidden rounded-b-full flex flex-col justify-end w-50 shrink-0">
              <div
                class="h-80 w-full mt-auto rounded-full bg-linear-to-b from-[#F5791A] to-[#B42323] flex flex-col justify-end">
                <img src="/assets/calon-2.png" class="h-auto mx-auto relative top-10" alt="">
              </div>
            </div>
          </div>
          <div class="flex">
            <Button class="w-50">Vote</Button>
          </div>
        </div> -->
        <!-- Calon 3 -->
        <!-- <div class="h-120 flex flex-col justify-between w-fit mx-auto">
          <div class="h-105 flex sm:flex-row-reverse items-end gap-4">
            <div class="h-80 flex flex-col justify-center grow">
              <h3 class="text-xl font-semibold">
                Malin Kundang
              </h3>
              <small>Sastra Informatika 23</small>
            </div>
            <div class="h-full overflow-hidden rounded-b-full flex flex-col justify-end w-50">
              <div
                class="h-80 w-full mt-auto rounded-full bg-linear-to-b from-[#F5791A] to-[#B42323] flex flex-col justify-end">
                <img src="/assets/calon-2.png" class="h-auto mx-auto relative top-10" alt="">
              </div>
            </div>
          </div>
          <div class="flex justify-center">
            <Button class="w-50">Vote</Button>
          </div>
        </div> -->
      </div>
    </div>
  </AppLayout>


  <Dialog :open="!!selectedKandidat" @update:open="(open) => selectedKandidat = (!open ? null : selectedKandidat)">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Vote Calon Ketua</DialogTitle>
        <DialogDescription class="mt-2">
          Anda yakin ingin memilih calon ketua nomor urut {{ selectedKandidat?.no_urut }}?
        </DialogDescription>
      </DialogHeader>

      <DialogFooter>
        <Button variant="outline" @click="selectedKandidat = null">Batal</Button>
        <Button @click="vote">Vote</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>