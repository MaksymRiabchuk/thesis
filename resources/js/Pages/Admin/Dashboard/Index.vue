<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { DollarSign, Package, Users, TrendingUp } from 'lucide-vue-next';

import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  ChartOptions
} from 'chart.js';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

defineOptions({
  layout: AdminLayout,
});

const stats = [
  { title: 'Total Revenue', value: '$45,231', icon: DollarSign },
  { title: 'Active Offers', value: '324', icon: Package },
  { title: 'Total Users', value: '1,209', icon: Users },
  { title: 'Renting Rate', value: '68%', icon: TrendingUp },
];

const chartData = {
  labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
  datasets: [
    {
      label: 'Revenue',
      backgroundColor: '#58A55C',
      borderRadius: 4,
      data: [4000, 3000, 2000, 2800, 1900, 2400, 3500],
    }
  ]
};

const chartOptions: ChartOptions<'bar'> = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: false },
  },
  scales: {
    y: {
      beginAtZero: true,
      border: { display: false },
      grid: {
        color: '#f3f4f6',
        drawTicks: false,
      },
      ticks: {
        stepSize: 1000,
        color: '#9ca3af',
        callback: (value) => '$' + value
      }
    },
    x: {
      border: { display: false },
      grid: { display: false },
      ticks: { color: '#9ca3af' }
    }
  }
};

const recentOffers = [
  { id: 1, title: 'Sony A7III Camera', category: 'Electronics', price: '$45/day', status: 'Active' },
  { id: 2, title: 'Mountain Bike (Trek)', category: 'Sports', price: '$20/day', status: 'Rented' },
  { id: 3, title: 'DJI Mavic Pro', category: 'Electronics', price: '$35/day', status: 'Active' },
  { id: 4, title: 'Camping Tent 4-person', category: 'Outdoors', price: '$15/day', status: 'Rented' },
];
</script>

<template>
  <Head title="Overview" />

  <div class=" mx-auto space-y-6">

    <h1 class="text-2xl font-bold text-slate-800">Overview</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div
          v-for="stat in stats"
          :key="stat.title"
          class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm flex items-center justify-between"
      >
        <div>
          <p class="text-sm font-medium text-slate-500 mb-1">{{ stat.title }}</p>
          <h3 class="text-2xl font-bold text-slate-800">{{ stat.value }}</h3>
        </div>
        <div class="bg-green-50 p-3 rounded-full flex items-center justify-center">
          <component :is="stat.icon" class="w-6 h-6 text-green-600" />
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-slate-100 shadow-sm">
        <h2 class="text-base font-semibold text-slate-800 mb-6">Revenue This Week</h2>
        <div class="h-75 w-full">
          <Bar :data="chartData" :options="chartOptions" />
        </div>
      </div>

      <div class="lg:col-span-1 bg-white rounded-xl p-6 border border-slate-100 shadow-sm flex flex-col">
        <h2 class="text-base font-semibold text-slate-800 mb-6">Recent Offers</h2>

        <div class="flex-1 flex flex-col gap-5">
          <div
              v-for="offer in recentOffers"
              :key="offer.id"
              class="flex items-center justify-between border-b border-slate-50 pb-4 last:border-0 last:pb-0"
          >
            <div>
              <p class="text-sm font-medium text-slate-800">{{ offer.title }}</p>
              <p class="text-xs text-slate-400 mt-0.5">{{ offer.category }}</p>
            </div>

            <div class="text-right flex flex-col items-end gap-1.5">
              <span class="text-sm font-medium text-slate-800">{{ offer.price }}</span>
              <span
                  :class="[
                                    'text-[11px] font-medium px-2.5 py-0.5 rounded-full',
                                    offer.status === 'Active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-blue-100 text-blue-700'
                                ]"
              >
                                {{ offer.status }}
                            </span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>