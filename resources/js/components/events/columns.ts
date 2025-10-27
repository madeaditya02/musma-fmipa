import { Kegiatan } from '@/types'
import { ColumnDef } from '@tanstack/vue-table'
import { h } from 'vue'
import EventActionDropdown from './EventActionDropdown.vue'

export interface Payment {
  id: string
  amount: number
  status: 'pending' | 'processing' | 'success' | 'failed'
  email: string
}
// Nama, Waktu Mulai, Waktu Selesai, Status (Berlangsung, Coming Soon, Selesai), Action
export const columns: ColumnDef<Kegiatan>[] = [
  {
    accessorKey: 'nama',
    header: () => h('div', 'Nama Kegiatan'),
    cell: ({ row }) => {
      return h('div', { class: 'text-left font-medium' }, row.getValue('nama'))
    },
  },
  {
    accessorKey: 'waktu_mulai',
    header: () => h('div', 'Waktu Mulai'),
    cell: ({ row }) => {
      return h('div', { class: 'text-left' }, row.getValue('waktu_mulai'))
    },
  },
  {
    accessorKey: 'waktu_selesai',
    header: () => h('div', 'Waktu Selesai'),
    cell: ({ row }) => {
      return h('div', { class: 'text-left' }, row.getValue('waktu_selesai'))
    },
  },
  {
    accessorKey: 'status',
    header: () => h('div', 'Status'),
    cell: ({ row }) => {
      const status: Kegiatan['status'] = row.getValue('status')
      return h('div', { class: 'inline-block text-xs px-2 py-1.5 rounded-xl font-medium ' + (status == 'Coming Soon' ? 'bg-yellow-100 text-yellow-800' : (status == 'Sedang Berlangsung' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')) }, status)
    },
  },
  {
    id: 'actions',
    enableHiding: false,
    cell: ({ row }) => {
      const kegiatan = row.original
      return h('div', { class: 'relative' }, h(EventActionDropdown, {
        kegiatan,
      }))
    },
  },
]