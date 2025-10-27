<script setup lang="ts">
import { columns } from '@/components/events/columns'
import DataTable from '@/components/events/data-table.vue'
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue'
import { Kegiatan } from '@/types'
import { Link } from '@inertiajs/vue3';

defineProps<{
  kegiatan: Kegiatan[]
}>()
</script>

<template>
  <AppLayout>
    <div class="container py-10 mx-auto px-8">
      <div class="flex justify-between items-end mb-5">
        <h1 class="text-3xl font-semibold">Data Kegiatan Pemilihan</h1>
        <Button as-child>
          <Link href="events/create">Tambah</Link>
        </Button>
      </div>
      <DataTable :columns="columns" :data="kegiatan" />
    </div>
  </AppLayout>
</template>