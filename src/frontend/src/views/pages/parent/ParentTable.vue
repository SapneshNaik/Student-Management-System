<template>
  <div id="ag-grid-demo">
    <vx-card title="All Parents">

      <!-- TABLE ACTION ROW -->
      <div class="flex flex-wrap justify-between items-center">

        <!-- ITEMS PER PAGE -->
        <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
          <vs-dropdown vs-trigger-click class="cursor-pointer">
            <div
              class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
              <span class="mr-2">{{ currentPage * paginationPageSize - (paginationPageSize - 1) }} - {{ parents.length - currentPage * paginationPageSize > 0 ? currentPage * paginationPageSize : parents.length }} of {{ parents.length }}</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4"/>
            </div>
            <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
            <vs-dropdown-menu>

              <vs-dropdown-item @click="gridApi.paginationSetPageSize(20)">
                <span>20</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(50)">
                <span>50</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(100)">
                <span>100</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(150)">
                <span>150</span>
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
        </div>

        <!-- TABLE ACTION COL-2: SEARCH & EXPORT AS CSV -->
        <div class="flex flex-wrap items-center justify-between ag-grid-table-actions-right">
          <vs-input class="mb-4 md:mb-0 mr-4" v-model="searchQuery" @input="updateSearchQuery" placeholder="Search..."/>
          <vs-button class="mb-4 md:mb-0" @click="gridApi.exportDataAsCsv()">Export as CSV</vs-button>
        </div>
      </div>
      <ag-grid-vue
        ref="agGridTable"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :rowData="parents"
        rowSelection="multiple"
        colResizeDefault="shift"
        :animateRows="true"
        :floatingFilter="true"
        :pagination="true"
        :paginationPageSize="paginationPageSize"
        :suppressPaginationPanel="true"
        :enableCellChangeFlash="true"
        :enableRtl="$vs.rtl"
        @row-double-clicked="rowClicked"

      >
      </ag-grid-vue>
      <vs-pagination
        :total="totalPages"
        :max="maxPageNumbers"
        v-model="currentPage"/>

    </vx-card>
  </div>
</template>

<script>
  import {AgGridVue} from "ag-grid-vue"

  import '@/assets/scss/vuexy/extraComponents/agGridStyleOverride.scss'

  export default {
    components: {
      AgGridVue
    },
    data() {
      return {
        searchQuery: '',
        gridOptions: {},
        maxPageNumbers: 7,
        gridApi: null,
        gridColumnApi: null,

        defaultColDef: {
          sortable: true,
          editable: false,
          resizable: true,
          suppressMenu: true
        },

        columnDefs: [
          {
            headerName: 'Father Name',
            pinned: 'left',
            filter: true,
            valueGetter:
              function sumField(params) {
                return params.data.father_full_name;
              },
          },
          {
            headerName: 'Mother Name',
            // field: 'first_name',
            filter: true,
            valueGetter:
              function sumField(params) {
                return params.data.mother_full_name;
              },
          },
          {
            headerName: 'Father Phone',
            // field: 'first_name',
            filter: true,
            valueGetter:
              function sumField(params) {
                return params.data.father_contact_number;
              },
          },
          {
            headerName: 'Mother Phone',
            // field: 'first_name',
            filter: true,
            valueGetter:
              function sumField(params) {
                return params.data.mother_contact_number;
              },
          },

          {
            headerName: 'Email',
            // field: 'first_name',
            filter: true,
            valueGetter:
              function sumField(params) {
                return params.data.user.email;
              },
          },

          {
            headerName: 'Status',
            // field: 'first_name',
            filter: true,
            valueGetter:
              function sumField(params) {
                return params.data.user.status;
              },
          },

          {
            headerName: 'Last Updated By',
            field: 'user.updater.login_id',
            filter: true,
          },

        ],

      }
    },
    watch: {

      parents: function (data) {
        if (data.length === 0) {
          this.$vs.notify({
            title: 'No Parent Records',
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            position: 'top-right',
            color: 'danger'
          });
          this.$vs.loading.close();

        } else {
          this.$vs.loading.close();
        }
      },

      '$store.state.windowWidth'(val) {
        if (val <= 576) {
          this.maxPageNumbers = 4
          this.gridOptions.columnApi.setColumnPinned('login_id', null)
        } else this.gridOptions.columnApi.setColumnPinned('login_id', 'left')
      }
    },
    computed: {

      parents() {
        return this.$store.state.userManagement.parents
      },

      paginationPageSize() {
        if (this.gridApi) return this.gridApi.paginationGetPageSize();
        else return 100
      },
      totalPages() {
        if (this.gridApi) return this.gridApi.paginationGetTotalPages();
        else return 0
      },
      currentPage: {
        get() {
          if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1;
          else return 1
        },
        set(val) {
          this.gridApi.paginationGoToPage(val - 1)
        }
      }
    },
    methods: {
      updateSearchQuery(val) {
        this.gridApi.setQuickFilter(val)
      },

      fetchData() {
        this.$store.dispatch("userManagement/getAllParents").then(() => {
          this.autoSizeColumns();

          this.gridApi.refreshCells();

          this.$vs.notify({
            title:'Sync Update',
            text:'Parent records synced with server',
            color:'success',
            position:'top-right'})

        }).catch((error) => {
          console.log(error);
        });
      },

      autoSizeColumns() {
        let allColumnIds = [];
        this.gridColumnApi.getAllColumns().forEach(function (column) {
          allColumnIds.push(column.colId);
        });
        this.gridColumnApi.autoSizeColumns(allColumnIds, false);
      },

      rowClicked(params) {
        this.$router.push({name: 'sms-user-profile', params: { id: params.data.user_id, role: params.data.user.base_role }}).catch(() => {})
      }

    },
    mounted() {
      this.gridApi = this.gridOptions.api;
      this.gridColumnApi = this.gridOptions.columnApi;
      this.autoSizeColumns();


      if (this.$vs.rtl) {
        const header = this.$refs.agGridTable.$el.querySelector(".ag-header-container")
        header.style.left = "-" + String(Number(header.style.transform.slice(11, -3)) + 9) + "px"
      }

      if(this.parents.length == 0) {
        this.$vs.loading();
      }

    },
    created() {
      this.fetchData()
    }
  }

</script>
