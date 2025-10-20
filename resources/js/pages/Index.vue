<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
  Card,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Kegiatan } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
  kegiatan: Kegiatan
}>()
</script>
<template>

  <Head title="Musma DPM FMIPA - Home" />

  <div class="container mx-auto">
    <div class="md:w-8/12 mx-auto mt-12">
      <div class="text-center">
        <h1 class="text-5xl font-bold mb-6">Musma DPM FMIPA</h1>
        <Button as-child>
          <Link :href="`/vote/${kegiatan.id}`">Vote Sekarang</Link>
        </Button>
      </div>

      <div class="grid grid-cols-2 gap-8 mt-20">
        <Card v-for="calon in kegiatan.kandidat" :key="calon.id">
          <CardHeader>
            <CardTitle class="text-2xl">{{ calon.mahasiswa ? calon.mahasiswa[0].nama : '' }}</CardTitle>
            <CardDescription>Kabinet Lorem Ipsum</CardDescription>
          </CardHeader>
          <!-- <CardContent>
            Card Content
          </CardContent> -->
          <CardFooter>
            <a href="#">Selengkapnya</a>
          </CardFooter>
        </Card>
      </div>
    </div>
  </div>
</template>