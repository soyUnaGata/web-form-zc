<template>

    <div class="container w-25 d-flex flex-column align-items-center mt-5">
        <form class="d-flex flex-column align-items-center mt-2 gap-2" @submit.prevent="storeData">
            <div>
                <label for="deal-name">
                    Deal name
                </label>
                <input v-model="dealName" class="form-control" type="text" name="deal-name" id="deal-name" placeholder="Ex: Benton" required>

            </div>

            <div>
                <label for="deal-stage">
                    Deal stage
                </label>
                <input v-model="dealStage" class="form-control" type="text" name="deal-stage" id="deal-stage" placeholder="Ex: Needs Analysis" required>
            </div>

            <div>
                <label for="acc-name">
                    Account name
                </label>
                <input v-model="accName" class="form-control" type="text" name="acc-name" id="acc-name" placeholder="Ex: Benton (Sample)" required>
            </div>

            <div>
                <label for="acc-site">
                    Account website
                </label>
                <input v-model="accSite" class="form-control" :class="{ 'is-invalid': validWebsite }" type="text" name="acc-site" id="acc-site" placeholder="Ex: http://bentonus.com/" required>
            </div>

            <div>
                <label for="acc-phone">
                    Account phone
                </label>
                <input v-model="accPhone" class="form-control" type="text" name="acc-phone" id="acc-phone" placeholder="Ex: 555-555-5555" required>
            </div>

            <div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>

        <p v-if="message" class="mt-2 text-success">{{ message }}</p>
        <p v-if="errorMessage" class="mt-2 text-danger">{{ errorMessage }}</p>
    </div>
</template>

<script setup>
import {computed, ref} from "vue";
   import axios from "axios";

   const dealName = ref("");
   const dealStage = ref("");
   const accName = ref("");
   const accSite = ref("");
   const accPhone = ref("");
   const message = ref ("");
   const errorMessage = ref ("");

   const validWebsite = computed(() => {
       const regex = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.|http:\/\/|https:\/\/|ftp:\/\/|){1}[^\x00-\x19\x22-\x27\x2A-\x2C\x2E-\x2F\x3A-\x3F\x5B-\x5E\x60\x7B\x7D-\x7F]+(\.[^\x00-\x19\x22\x24-\x2C\x2E-\x2F\x3C\x3E\x40\x5B-\x5E\x60\x7B\x7D-\x7F]+)+([\/\?].*)*$/;
       return !regex.test(accSite.value);
   });

   const storeData = () => {
       axios.post('api/deals',{name: dealName.value,
           stage: dealStage.value,
           accName: accName.value,
           accSite : accSite.value,
           accPhone: accPhone.value
       })
           .then(res => {
               dealName.value = '';
               dealStage.value = '';
                   accName.value = '';
                   accSite.value = '';
                   accPhone.value = '';
               message.value = res.data;

           })
           .catch((error) =>
               errorMessage.value = error)
   }

</script>
