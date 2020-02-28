<!-- =========================================================================================
    File Name: NumberInput.vue
    Description: Rendering number input with label
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <vx-card title="Label" code-toggler>

        <p>Number Input supports adding labels for number inputs.</p>

        <div class="demo-alignment">
            <vs-input-number v-model="passengers" label="passengers:"/>
        </div>

        <template slot="codeContainer">
&lt;template&gt;
  &lt;div class=&quot;centerx&quot;&gt;
    &lt;vs-input-number v-model=&quot;passengers&quot; label=&quot;passengers:&quot;/&gt;
  &lt;/div&gt;
&lt;/template&gt;

&lt;script&gt;
export default {
  data(){
    return {
      passengers:1,
    }
  }
}
&lt;/script&gt;
        </template>
    </vx-card>
</template>

<script>
export default {
    data() {
        return {
            passengers: 1
        }
    }
}
</script>
