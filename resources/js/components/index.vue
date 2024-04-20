<template>

    <div class="container w-25 d-flex flex-column align-items-center mt-5">
        <form class="d-flex flex-column align-items-center mt-2 gap-2">
            <div>
                <label for="deal-name">
                    Deal name
                </label>
                <input v-model="dealName" class="form-control" type="text" name="deal-name" id="deal-name" placeholder="Ex: Benton">
            </div>

            <div>
                <label for="deal-stage">
                    Deal stage
                </label>
                <input v-model="dealStage" class="form-control" type="text" name="deal-stage" id="deal-stage" placeholder="Ex: Needs Analysis">
            </div>

            <div>
                <label for="acc-name">
                    Account name
                </label>
                <input v-model="accName" class="form-control" type="text" name="acc-name" id="acc-name" placeholder="Ex: Benton (Sample)">
            </div>

            <div>
                <label for="email">
                    Account e-mail
                </label>
                <input v-model="accEmail" class="form-control" type="email" name="email" id="email" placeholder="Ex: john-buttbenton@noemail.com">
            </div>

            <div>
                <label for="acc-site">
                    Account website
                </label>
                <input v-model="accSite" class="form-control" type="text" name="acc-site" id="acc-site" placeholder="Ex: http://bentonus.com/">
            </div>

            <div>
                <label for="acc-phone">
                    Account phone
                </label>
                <input v-model="accPhone" class="form-control" type="text" name="acc-phone" id="acc-phone" placeholder="Ex: 555-555-5555">
            </div>

            <div>
                <button @click.prevent="storeData" class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
</template>

<script setup>
   import {ref} from "vue";
   import axios from "axios";

   const dealName = ref("");
   const dealStage = ref("");
   const accName = ref("");
   const accEmail = ref("");
   const accSite = ref("");
   const accPhone = ref("");

   const storeData = () => {
       axios.post('/api/deals',
           {name: dealName.value,
               stage: dealStage.value,
               accName: accName.value,
               accEmail: accEmail.value,
               accSite : accSite.value,
               accPhone: accPhone.value})
           .then(res => {
               console.log(res);
           })
   }

</script>
