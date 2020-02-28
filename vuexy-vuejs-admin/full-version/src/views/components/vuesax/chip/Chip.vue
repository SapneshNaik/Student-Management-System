<!-- =========================================================================================
  File Name: Chip.vue
  Description: Chip - Imports all page portions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="chip-demo">
    <chip-default />
    <chip-color />
    <chip-transparent />
    <chip-icon />
    <chip-closable />
    <chip-add-remove />
    <chip-customize-close-clear-chip-icon />
  </div>
</template>

<script>
import ChipDefault                     from './ChipDefault.vue'
import ChipColor                       from './ChipColor.vue'
import ChipTransparent                 from './ChipTransparent.vue'
import ChipIcon                        from './ChipIcon.vue'
import ChipClosable                    from './ChipClosable.vue'
import ChipAddRemove                   from './ChipAddRemove.vue'
import ChipCustomizeCloseClearChipIcon from './ChipCustomizeCloseClearChipIcon.vue'

export default {
  components: {
    ChipDefault,
    ChipColor,
    ChipTransparent,
    ChipIcon,
    ChipClosable,
    ChipAddRemove,
    ChipCustomizeCloseClearChipIcon,
  }
}

</script>

