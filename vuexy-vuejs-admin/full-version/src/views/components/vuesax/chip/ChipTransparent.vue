<!-- =========================================================================================
    File Name: ChipTransparent.vue
    Description: Transparent chip variant
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template lang="html">

  <vx-card title="Transparent" code-toggler>

    <p>You can create transparent chip using <code>transparent</code> prop.</p>


    <div class="demo-alignment">
      <vs-chip transparent color="primary">
        Basic Chip
      </vs-chip>
      <vs-chip transparent color="success">
        <vs-avatar text="LD"/>
        Avatar Text
      </vs-chip>
      <vs-chip transparent color="danger">
        <vs-avatar />
        Avatar Icon
      </vs-chip>
      <vs-chip transparent color="warning">
        <vs-avatar src="https://randomuser.me/api/portraits/men/4.jpg"/>
        Avatar Image
      </vs-chip >
      <vs-chip transparent closable color="dark">
        Closable chip
      </vs-chip>
      <vs-chip transparent closable color="#24c1a0" close-icon="close">
        <vs-avatar src="https://randomuser.me/api/portraits/men/16.jpg"/>
        Closable chip
      </vs-chip>
    </div>

    <template slot="codeContainer">
&lt;template&gt;
  &lt;div class=&quot;demo-alignment&quot;&gt;
    &lt;vs-chip transparent color=&quot;primary&quot;&gt;
      Basic Chip
    &lt;/vs-chip&gt;
    &lt;vs-chip transparent color=&quot;success&quot;&gt;
      &lt;vs-avatar text=&quot;LD&quot;/&gt;
      Avatar Text
    &lt;/vs-chip&gt;
    &lt;vs-chip transparent color=&quot;danger&quot;&gt;
      &lt;vs-avatar /&gt;
      Avatar Icon
    &lt;/vs-chip&gt;
    &lt;vs-chip transparent color=&quot;warning&quot;&gt;
      &lt;vs-avatar src=&quot;https://randomuser.me/api/portraits/men/4.jpg&quot;/&gt;
      Avatar Image
    &lt;/vs-chip &gt;
    &lt;vs-chip transparent closable color=&quot;dark&quot;&gt;
      Closable chip
    &lt;/vs-chip&gt;
    &lt;vs-chip transparent closable color=&quot;#24c1a0&quot; close-icon=&quot;close&quot;&gt;
      &lt;vs-avatar src=&quot;https://randomuser.me/api/portraits/men/16.jpg&quot;/&gt;
      Closable chip
    &lt;/vs-chip&gt;
  &lt;/div&gt;
&lt;/template&gt;
    </template>
  </vx-card>

</template>
