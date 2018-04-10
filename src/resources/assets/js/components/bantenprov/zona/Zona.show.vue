<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Zona 

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
            <b>Nama Siswa :</b> {{ model.siswa.nama_siswa }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Master Zona ID :</b> {{ model.master_zona_id }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Sekolah ID :</b> {{ model.sekolah_id }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Zona Siswa :</b> {{ model.zona_siswa }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Zona Sekolah :</b> {{ model.zona_sekolah }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Lokasi Siswa :</b> {{ model.lokasi_siswa }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Lokasi Sekolah :</b> {{ model.lokasi_sekolah }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nilai Zona :</b> {{ model.nilai_zona }}
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
    axios.get('api/zona/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.user = response.data.user;
          this.model.siswa = response.data.siswa;
          this.model.master_zona_id  = response.data.zona.master_zona_id;
          this.model.sekolah_id  = response.data.zona.sekolah_id;
          this.model.zona_siswa  = response.data.zona.zona_siswa;
          this.model.zona_sekolah  = response.data.zona.zona_sekolah;
          this.model.lokasi_siswa  = response.data.zona.lokasi_siswa;
          this.model.lokasi_sekolah  = response.data.zona.lokasi_sekolah;
          this.model.nilai_zona  = response.data.zona.nilai_zona;
          this.model.created_at = response.data.zona.created_at;
          this.model.updated_at = response.data.zona.updated_at;
          }
            else{
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
        user : "",
        master_zona_id: "",
        siswa: "",
        sekolah_id : "",
        zona_siswa: "",
        zona_sekolah : "",
        lokasi_siswa: "",
        lokasi_sekolah : "",
        nilai_zona: "",
        created_at: "",
        updated_at: ""
      },
      user: [],
      siswa: []
    }
  },
  methods: {
    back() {
      window.location = '#/admin/zona';
    }
  }
}
</script>
