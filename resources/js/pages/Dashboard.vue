<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { Kegiatan, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import {
  Card,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { useEcho } from '@laravel/echo-vue';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
];

const props = defineProps<{
  kegiatan: Kegiatan
}>()

const kegiatan = ref(props.kegiatan)

useEcho(
  `event.${kegiatan.value.id}`,
  "VoteCandidate",
  (e: { kegiatan: Kegiatan }) => {
    kegiatan.value = e.kegiatan
  },
).listen();
</script>

<template>

  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <!-- <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div> -->
      <h1 class="text-4xl font-semibold text-center">{{ kegiatan.nama }}</h1>
      <div class="grid grid-cols-2 gap-8 mt-20">
        <div v-for="calon in kegiatan.kandidat" :key="calon.id">
          <h2 class="text-3xl font-semibold text-center mb-8">{{ calon.jumlah_suara }}</h2>
          <Card>
            <CardHeader>
              <CardTitle class="text-2xl">{{ calon.mahasiswa ? calon.mahasiswa[0].nama : '' }}</CardTitle>
              <CardDescription>Kabinet Lorem Ipsum</CardDescription>
            </CardHeader>
            <CardFooter>
              <!-- <a href="#">Selengkapnya</a> -->
            </CardFooter>
          </Card>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
