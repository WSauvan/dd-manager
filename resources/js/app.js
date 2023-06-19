import { createApp } from 'vue/dist/vue.esm-bundler';
import { pascalToKebab } from './utils/String';

import ExampleComponent from './components/ExampleComponent.vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Instantiate Vue root components
[ExampleComponent].forEach((c) => {
  const componentName = c.__name || c.name;

  if (process.env.NODE_ENV === 'development' && !componentName) {
    throw new Error('Component name is undefined.');
  }

  [...document.getElementsByTagName(pascalToKebab(componentName))].forEach(
    (element) => {
      const wrapper = document.createElement('div');
      element.parentNode.insertBefore(wrapper, element);
      wrapper.appendChild(element);

      const app = createApp(wrapper);
      app.component(componentName, c);
      app.mount(wrapper);
    }
  );
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
