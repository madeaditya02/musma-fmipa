<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Kegiatan } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { Card, CardHeader, CardContent, CardTitle, CardDescription, CardFooter } from '@/components/ui/card';
import Autoplay from "embla-carousel-autoplay"
import { Carousel, CarouselContent, CarouselItem, } from "@/components/ui/carousel"

const plugin = Autoplay({ delay: 4000, stopOnInteraction: false });

const props = defineProps<{
    kegiatan?: Kegiatan
}>()

// Countdown timer logic
const currentTime = ref(new Date());
let interval: number | null = null;

const timeRemaining = computed(() => {
    // console.log(props)

    const target = new Date(props.kegiatan?.waktu_mulai_raw ?? '');
    const now = currentTime.value;
    const diff = target.getTime() - now.getTime();

    if (diff <= 0) {
        return { days: 0, hours: 0, minutes: 0, seconds: 0, expired: true };
    }

    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

    return { days, hours, minutes, seconds, expired: false };
});

const formatTime = (time: number) => {
    return time.toString().padStart(2, '0');
};

// Set up interval to update current time every second
onMounted(() => {
    interval = setInterval(() => {
        currentTime.value = new Date();
    }, 1000);
});

onUnmounted(() => {
    if (interval) {
        clearInterval(interval);
    }
});

const page = usePage();
const auth = computed(() => page.props.auth);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Beranda',
        href: '/dashboard',
    },
];
</script>
<template>

    <Head title="Musma DPM FMIPA - Home" />

    <AppLayout :breadcrumbs="breadcrumbs" background="main">

        <div class="flex h-full flex-1 flex-col gap-8 overflow-x-auto">
            <div class="relative min-h-[90vh] flex flex-1 justify-center items-center">
                <Carousel class="absolute w-full saturate-0 md:saturate-0 md:backdrop-blur" :plugins="[plugin]"
                    @mouseenter="plugin.stop" @mouseleave="[plugin.reset(), plugin.play()]">
                    <CarouselContent>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center ">
                                        <img src="/images/banner_1.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center">
                                        <img src="/images/Banner_2.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center">
                                        <img src="/images/Banner_3.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center">
                                        <img src="/images/Banner_4.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center">
                                        <img src="/images/Banner_5.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center">
                                        <img src="/images/Banner_6.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center">
                                        <img src="/images/Banner_7.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center">
                                        <img src="/images/Banner_8.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                        <CarouselItem>
                            <div class="p-1 flex items-center justify-center">
                                <Card class="w-full">
                                    <CardContent class="flex items-center justify-center">
                                        <img src="/images/Banner_9.webp" alt="Placeholder"
                                            class="w-full h-[90vh] object-cover" />
                                    </CardContent>
                                </Card>
                            </div>
                        </CarouselItem>
                    </CarouselContent>
                </Carousel>
                <!-- Background image with overlay -->
                <img src="/assets/background-hero.png" alt="Background PEMIRA"
                    class="absolute top-0 inset-0 h-full w-full object-cover" />

                <!-- Content with relative positioning and higher z-index -->
                <div class="relative z-10 px-4 space-y-4 md:space-y-6 flex flex-col items-center justify-center"
                    v-if="kegiatan">
                    <!-- Header -->
                    <div class="text-center">
                        <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-foreground mb-2">
                            Musyawarah Mahasiswa FMIPA
                        </h2>
                        <p class="text-sidebar-foreground font-medium text-sm md:text-base max-w-lg">
                            Pemilihan Ketua Dewan Perwakilan Mahasiswa Fakultas Matematika dan Ilmu Pengetahuan Alam
                            tahun {{
                                dayjs().year() }} akan dimulai dalam
                        </p>
                    </div>

                    <!-- Countdown Display -->
                    <div class="flex justify-center space-x-4 items-start">
                        <!-- Days -->
                        <div class="text-center">
                            <p class="text-4xl md:text-5xl lg:text-6xl font-bold text-foreground">
                                {{ formatTime(timeRemaining.days) }}
                            </p>
                            <p class="text-sm lg:text-base text-sidebar-foreground font-medium mt-2">
                                Hari
                            </p>
                        </div>

                        <div class="pt-2 text-xl md:text-2xl lg:text-3xl font-bold text-muted-foreground">:</div>

                        <!-- Hours -->
                        <div class="text-center">
                            <p class="text-4xl md:text-5xl lg:text-6xl font-bold text-foreground">
                                {{ formatTime(timeRemaining.hours) }}
                            </p>
                            <p class="text-sm lg:text-base text-sidebar-foreground font-medium mt-2">
                                Jam
                            </p>
                        </div>

                        <div class="pt-2 text-xl md:text-2xl lg:text-3xl font-bold text-muted-foreground">:</div>

                        <!-- Minutes -->
                        <div class="text-center">
                            <p class="text-4xl md:text-5xl lg:text-6xl font-bold text-foreground">
                                {{ formatTime(timeRemaining.minutes) }}
                            </p>
                            <p class="text-sm lg:text-base text-sidebar-foreground font-medium mt-2">
                                Menit
                            </p>
                        </div>

                        <div class="pt-2 text-xl md:text-2xl lg:text-3xl font-bold text-muted-foreground">:</div>

                        <!-- Seconds -->
                        <div class="text-center">
                            <p class="text-4xl md:text-5xl lg:text-6xl font-bold text-foreground">
                                {{ formatTime(timeRemaining.seconds) }}
                            </p>
                            <p class="text-sm lg:text-base text-sidebar-foreground font-medium mt-2">
                                Detik
                            </p>
                        </div>
                    </div>

                    <!-- Status Message -->
                    <Button variant="outline" size="lg" class="text-base" as-child>
                        <Link :href="auth.user ? `/vote/${kegiatan?.id}` : '/login'">
                        Vote Sekarang!
                        </Link>
                    </Button>
                </div>

                <div class="relative z-10 px-4 space-y-4 md:space-y-6 flex flex-col items-center justify-center" v-else>
                    <h2 class="text-xl md:text-4xl font-semibold mb-4">Coming Soon</h2>
                    <h2 class="text-2xl md:text-5xl font-semibold">Musma FMIPA {{ dayjs().year() }}</h2>
                    <p class="text-sidebar-foreground font-medium text-sm md:text-base max-w-2xl text-center">
                        Pemilihan Ketua Dewan Perwakilan Mahasiswa Fakultas Matematika dan Ilmu Pengetahuan Alam tahun
                        {{
                            dayjs().year() }} akan segera hadir! Tunggu dan pantau selalu informasinya.
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
