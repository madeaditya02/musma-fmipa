<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Kegiatan, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/components/ui/accordion"
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
    href: '/dashboard',
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

// Accordion FAQ data
const defaultValue = "item-1"
const accordionItems = [
  { value: "item-1", title: "Apa saja syarat untuk mengikuti pemilihan?", content: "Anda harus terdaftar sebagai mahasiswa aktif di fakultas dan program studi yang sesuai, serta terdaftar sebagai calon fungsionaris DPM FMIPA di periode tahun selanjutnya." },
  { value: "item-2", title: "Bagaimana cara melakukan registrasi akun?", content: "Anda cukup menyiapkan NIM dan nama lengkap yang sesuai dengan profil pada laman IMISSU. Kemudian, ikuti langkah-langkah yang terdapat pada laman registrasi akun." },
  { value: "item-3", title: "Bagaimana cara login ke dalam laman pemilihan?", content: "Anda dapat melakukan login dengan menggunakan email dan kata sandi yang telah Anda daftarkan sebelumnya. Pastikan email yang terdaftar merupakan email aktif dari universitas." },
  { value: "item-4", title: "Bagaimana jika saya lupa kata sandi?", content: "Anda dapat melakukan reset kata sandi melalui laman login dengan mengklik tautan 'Lupa kata sandi?'. Ikuti langkah-langkah yang diberikan untuk mengatur ulang kata sandi Anda." },
  { value: "item-5", title: "Kegiatan apa saja yang dapat saya ikuti?", content: "Anda dapat mengikuti kegiatan pemilihan umum untuk memilih calon ketua DPM FMIPA periode tahun selanjutnya." },
  { value: "item-6", title: "Bagaimana tata cara melakukan pemilihan?", content: "Anda diharuskan login terlebih dahulu untuk dapat melakukan pemilihan. Kemudian, Anda dapat melihat informasi kandidat setiap kegiatan sebelum melakukan pemilihan. Setelah memulai proses pemilihan, Anda harus menyelesaikan pemilihan sebelum Anda dapat keluar dari situs pemilihan." },
  { value: "item-7", title: "Apakah saya dapat mengubah pilihan saya setelah memilih?", content: "Tidak, setelah Anda mengklik tombol 'Selesai' pada halaman pemilihan, pilihan Anda akan terkunci dan tidak dapat diubah. Anda juga hanya memiliki kesempatan sekali saja untuk melakukan pemilihan." },
  { value: "item-8", title: "Bagaimana cara memperbarui profil dan akun?", content: "Anda dapat memperbarui profil dan akun Anda melalui halaman pengaturan akun. Anda juga dapat mengubah kata sandi Anda di halaman ini. Pastikan untuk menyimpan segala perubahan yang telah Anda buat." },
]

const heroImages = [
  '/images/foto-slide-hero/hero-image-1.jpg',
  '/images/foto-slide-hero/hero-image-2.jpg',
  '/images/foto-slide-hero/hero-image-3.jpg',
]
</script>

<template>

  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <h1 class="text-4xl font-semibold text-center">{{ kegiatan.nama }}</h1>
      <div class="grid grid-cols-2 gap-8 mt-20">
        <div v-for="calon in kegiatan.kandidat" :key="calon.id">
          <h2 class="text-3xl font-semibold text-center mb-8">{{ calon.jumlah_suara }}</h2>
          <Card>
            <CardHeader>
              <CardTitle class="text-2xl">{{ calon.mahasiswa ? calon.mahasiswa[0].nama : '' }}</CardTitle>
              <CardDescription>Kabinet Lorem Ipsum</CardDescription>
            </CardHeader>
          </Card>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
