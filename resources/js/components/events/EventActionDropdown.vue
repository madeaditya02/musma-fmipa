<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Link } from '@inertiajs/vue3';
import { Kegiatan } from '@/types';

defineProps<{
  kegiatan: Kegiatan
}>()
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="w-4 h-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuItem as-child>
        <Link :href="`events/${kegiatan.id}/edit`">Edit</Link>
      </DropdownMenuItem>
      <DropdownMenuItem as-child>
        <Link :href="`events/${kegiatan.id}/candidates`">Kandidat</Link>
      </DropdownMenuItem>
      <DropdownMenuItem as-child>
        <Link :href="`events/${kegiatan.id}/delete`" method="delete" class="w-full">Delete</Link>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>