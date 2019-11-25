<template>
    <v-form>
        <v-card style="overflow: hidden;" max-width="100%">
            <v-card-title>
                Add Offer
                <v-spacer></v-spacer>
                <v-btn icon v-on:click="$emit('closeAddOfferDialog')">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    :rules="[rules.required]"
                    :counter="32"
                    v-model="title"
                    placeholder="Your Title ..."
                    label="Title"
                ></v-text-field>
                <v-textarea
                    :rules="[rules.required]"
                    :counter="600"
                    v-model="body"
                    placeholder="Your Description ..."
                    label="Description"
                ></v-textarea>
            </v-card-text>
            <v-card-actions class="pb-0">
                <v-container class="pa-0">
                    <v-row class="pl-3 pr-5">
                        <v-file-input
                            v-model="file"
                        ></v-file-input>
                        <v-img
                            :src="file"
                        ></v-img>
                    </v-row>
                    
                    <v-row class="pa-0">
                        <!-- escape buttons -->
                        <v-btn 
                            style="border-radius: 0 0 0 5px;"
                            text color="primary" d-inline-block width="50%" height="50px"
                            @click="check()"
                        >Submit</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn 
                            style="border-radius: 0 0 5px 0;"
                            text d-inline-block width="50%" height="50px"
                            v-on:click="$emit('closeAddOfferDialog')"
                        >Cancel</v-btn>
                    </v-row>
                </v-container>
            </v-card-actions>
        </v-card>
    </v-form>
</template>

<script>
import external_rules from '@/plugins/rules/rules.js'

export default {
    data() {
        return {
            title: null,
            body: null,
            file: null,

            rules: external_rules
        }
    },
    methods: {
        check() {
            console.log(this.file)
        }
    },
}
</script>