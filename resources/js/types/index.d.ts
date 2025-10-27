import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    alert: {title: string; message: string, type: string} | null
};

export interface ProgramStudi {
    kode: string;
    nama: string;
}

export interface User {
    nim: string;
    nama: string;
    email: string;
    avatar?: string;
    angkatan: number;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    is_admin: boolean;
    program_studi: ProgramStudi;
}

export interface Kegiatan {
    id: number;
    nama: string;
    tahun: number;
    waktu_mulai: string;
    waktu_mulai_raw: string;
    waktu_selesai: string;
    waktu_selesai_raw: string;
    status: 'Coming Soon' | 'Sedang Berlangsung' | 'Selesai';
    kandidat?: Kandidat[];
    foto: string;
    total_mahasiswa: number;
    jumlah_pemilih: number;
    ruang_lingkup: string;
}

export interface Kandidat {
    id: number;
    no_urut: string;
    foto: string;
    visi: string;
    misi: string;
    jumlah_suara: number;
    kegiatan?: Kegiatan;
    mahasiswa?: User[];
}

export type BreadcrumbItemType = BreadcrumbItem;
