<!-- =========================================================================================
    File Name: TextareaHeight.vue
    Description: Set height of textarea
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <vx-card title="Height" code-toggler>

        <span>You can set the height of the textarea with the <code>height</code> prop.</span>

        <div class="mt-5">
            <vs-textarea v-model="textarea" label="Height set to 200px" height="200px" />
        </div>

        <template slot="codeContainer">
&lt;template&gt;
  &lt;div&gt;
    &lt;vs-textarea v-model=&quot;textarea&quot; label=&quot;Height set to 200px&quot; height=&quot;200px&quot; /&gt;
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
