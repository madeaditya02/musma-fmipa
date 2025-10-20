<script setup lang="ts">
import { Kandidat, Kegiatan } from '@/types';
import { router } from "@inertiajs/vue3";
import {
  Card,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog'
import { ref } from 'vue';

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
  <div class="container mx-auto">
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
  </div>

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