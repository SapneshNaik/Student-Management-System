<!-- =========================================================================================
    File Name: TextareaWidth.vue
    Description: Set width of textarea
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <vx-card title="Width" code-toggler>

        <span>You can set the width of the textarea with the <code>width</code> prop.</span>

        <div class="mt-5">
            <vs-textarea v-model="textarea" label="Width set to 300px" width="300px" />
        </div>

        <template slot="codeContainer">
&lt;template&gt;
  &lt;div&gt;
    &lt;vs-textarea v-model=&quot;textarea&quot; label=&quot;Height set to 300px&quot; width=&quot;300px&quot; /&gt;
  &lt;/div&gt;
&lt;/template&gt;

&lt;script&gt;
export default {
  data:()=&gt;({
    textarea: &apos;&apos;,
  })
}
&lt;/script&gt;
        </template>
    </vx-card>
</template>

<script>
export default {
    data: () => ({
        textarea: '',
    })
}
</script>
