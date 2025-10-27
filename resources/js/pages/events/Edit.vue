<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { Kegiatan } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { parseDate } from '@internationalized/date';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import dayjs from 'dayjs';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { CalendarIcon } from 'lucide-vue-next';
import utc from "dayjs/plugin/utc";
import timezone from "dayjs/plugin/timezone";
import InputError from '@/components/InputError.vue';

dayjs.extend(utc)
dayjs.extend(timezone)

const { kegiatan } = defineProps<{
  kegiatan: Kegiatan
}>()
const form = useForm({
  nama: kegiatan.nama,
  waktu_mulai_tanggal: parseDate(dayjs.tz(kegiatan.waktu_mulai_raw, 'Asia/Makassar').format('YYYY-MM-DD')) as any,
  waktu_mulai_jam: dayjs.tz(kegiatan.waktu_mulai_raw, 'Asia/Makassar').format('HH:mm'),
  waktu_selesai_tanggal: parseDate(dayjs.tz(kegiatan.waktu_selesai_raw, 'Asia/Makassar').format('YYYY-MM-DD')) as any,
  waktu_selesai_jam: dayjs.tz(kegiatan.waktu_selesai_raw, 'Asia/Makassar').format('HH:mm')
})
</script>
<template>
  <AppLayout>
    <form @submit.prevent="form.transform(data => ({
      ...data,
      waktu_mulai_tanggal: data.waktu_mulai_tanggal.toString(),
      waktu_selesai_tanggal: data.waktu_selesai_tanggal.toString(),
    })).put(`/events/${kegiatan.id}`)" class="container mx-auto px-8 py-10">
      <h1 class="text-3xl font-semibold">Edit Data Kegiatan</h1>
      <div class="mt-4 grid grid-cols-2 gap-6">
        <div class="">
          <Label>Nama Kegiatan</Label>
          <Input placeholder="Nama kegiatan" v-model="form.nama" class="mt-2" />
          <InputError :message="form.errors.nama" class="mt-1" />
        </div>
        <div class="">
          <Label>Waktu Mulai</Label>
          <div class="flex gap-2 mt-2 relative">
            <Popover>
              <PopoverTrigger as-child>
                <Button variant="outline" :class="cn(
                  'w-full shrink justify-start text-left font-normal',
                  !form.waktu_mulai_tanggal && 'text-muted-foreground',
                )">
                  <CalendarIcon class="mr-2 h-4 w-4" />
                  {{ form.waktu_mulai_tanggal ?? "Pick a date" }}
                </Button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <Calendar v-model="form.waktu_mulai_tanggal" initial-focus />
              </PopoverContent>
            </Popover>
            <div class="w-32 relative">
              <Input type="time" class="w-full" v-model="form.waktu_mulai_jam" />
            </div>
          </div>
          <InputError :message="form.errors.waktu_mulai_tanggal ?? form.errors.waktu_mulai_jam" class="mt-1" />
        </div>
        <div class="">
          <Label>Waktu Selesai</Label>
          <div class="flex gap-2 mt-2 relative">
            <Popover>
              <PopoverTrigger as-child>
                <Button variant="outline" :class="cn(
                  'w-full shrink justify-start text-left font-normal',
                  !form.waktu_selesai_tanggal && 'text-muted-foreground',
                )">
                  <CalendarIcon class="mr-2 h-4 w-4" />
                  {{ form.waktu_selesai_tanggal ?? "Pick a date" }}
                </Button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <Calendar v-model="form.waktu_selesai_tanggal" initial-focus />
              </PopoverContent>
            </Popover>
            <div class="w-32 relative">
              <Input type="time" class="w-full" v-model="form.waktu_selesai_jam" />
            </div>
          </div>
          <InputError :message="form.errors.waktu_mulai_tanggal ?? form.errors.waktu_mulai_jam" class="mt-1" />
        </div>
      </div>
      <Button class="mt-4">Simpan</Button>
    </form>
  </AppLayout>
</template>