<template>
  <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
    <!-- If the listing has images, display them, else display a message. -->
    <Box v-if="listing.images.length" class="md:col-span-7 flex items-center">
      <div class="grid grid-cols-2 gap-1">
        <img v-for="image in listing.images" :key="image.id" :src="image.src" />
      </div>
    </Box>

    <EmptyState v-else class="md:col-span-7 flex items-center"
      >No images</EmptyState
    >

    <div class="md:col-span-5 flex flex-col gap-4">
      <Box>
        <template #header> Basic info </template>
        <Price :price="listing.price" class="text-2xl font-bold" />
        <ListingSpace :listing="listing" class="text-lg" />
        <ListingAddress :listing="listing" class="text-gray-500" />
      </Box>

      <Box>
        <template #header> Monthly Payment </template>
        <div>
          <label class="label">Interest rate ({{ interestRate }}%)</label>
          <input
            v-model.number="interestRate"
            type="range"
            min="0.1"
            max="30"
            step="0.1"
            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
          />

          <label class="label">Duration ({{ duration }} years)</label>
          <input
            v-model.number="duration"
            type="range"
            min="3"
            max="35"
            step="1"
            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
          />

          <div class="text-gray-600 dark:text-gray-300 mt-2">
            <div class="text-gray-400">Your monthly payment</div>
            <Price :price="monthlyPayment" class="text-3xl" />
          </div>

          <div class="mt-2 text-gray-500">
            <div class="flex justify-between">
              <div>Total paid</div>
              <div>
                <Price :price="totalPaid" class="font-medium" />
              </div>
            </div>
            <div class="flex justify-between">
              <div>Principal paid</div>
              <div>
                <Price :price="listing.price" class="font-medium" />
              </div>
            </div>
            <div class="flex justify-between">
              <div>Interest paid</div>
              <div>
                <Price :price="totalInterest" class="font-medium" />
              </div>
            </div>
          </div>
        </div>
      </Box>
      <!-- if the user is authenticated and the offerMade is falsy, show the MakeOffer component -->
      <!-- Passing data to child component using props -->
      <MakeOffer
        v-if="user && !offerMade"
        :listing-id="listing.id"
        :price="listing.price"
        @offer-updated="offer = $event"
      />
      <!-- if the user is authenticated and the offerMade is truthy, show the OfferMade component -->
      <OfferMade v-if="user && offerMade" :offer="offerMade" />
    </div>
  </div>
</template>

<script setup>
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";
import MakeOffer from "@/Pages/Listing/Show/Components/MakeOffer.vue";
import OfferMade from "./Show/Components/OfferMade.vue";
import EmptyState from '@/Components/UI/EmptyState.vue'
import { useMonthlyPayment } from "@/Composables/useMonthlyPayment";

import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const interestRate = ref(2.5);
const duration = ref(25);

const props = defineProps({
  // Receive the listing and offerMade props from the ListingController
  listing: Object,
  offerMade: Object,
});

// Create a new reactive variable to store the offer
const offer = ref(props.listing.price);
// Use destructuring to get the parameters from the useMonthlyPayment composable
const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(
  offer,
  interestRate,
  duration
);
// if the user is authenticated, show the MakeOffer component
const page = usePage();
const user = computed(() => page.props.user);
</script>
