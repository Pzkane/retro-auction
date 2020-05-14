import Vuetify from 'vuetify'

let output;

const subvertVue = {
    use (Installer, options) {
        output = {
            ...options
        }
    }
};

Vuetify.install(subvertVue);

const components = output.components;
const directives = output.directives;

export { output as default, components, directives };