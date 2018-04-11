<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Master Zona

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Tingkat :</b> {{ model.tingkat }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Kode :</b> {{ model.kode }}
          </div>
        </div>

        <div class="form-row mt-4">
					<div class="col-md">
						<b>Label :</b> {{ model.label }}
					</div>
				</div>

      </vue-form>
    </div>
       <div class="card-footer text-muted">
        <div class="row">
          <div class="col-md">
            <b>Username :</b> {{ model.user.name }}
          </div>
          <div class="col-md">
            <div class="col-md text-right">Dibuat : {{ model.created_at }}</div>
            <div class="col-md text-right">Diperbaiki : {{ model.updated_at }}</div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('api/master-zona/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.label = response.data.master_zona.label;
          this.model.tingkat = response.data.master_zona.tingkat;
          this.model.kode = response.data.master_zona.kode;
          this.model.user = response.data.user;
          this.model.created_at = response.data.master_zona.created_at;
          this.model.updated_at = response.data.master_zona.updated_at;
        } else {
          alert('Failed');
        }
        })
      .catch(function(response) {
        alert('Break');
      })
  },
  data() {
    return {
      state: {},
      model: {
        label: "",
        tingkat: "",
        user:"",
        kode: "",
        created_at: "",
        updated_at: "",
      },
      user: []
    }
  },
  methods: {
    back() {
      window.location = '#/admin/master-zona';
    }
  }
}
</script>
