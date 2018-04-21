<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Edit Zona

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
            <validate tag="div">
            <label for="siswa_id">Nama Siswa</label>
            <v-select name="siswa_id" v-model="model.siswa" :options="siswa" class="mb-4"></v-select>

            <field-messages name="siswa_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nama Siswa is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>  

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="sekolah_id">Sekolah</label>
            <v-select name="sekolah_id" v-model="model.sekolah" :options="sekolah" class="mb-4"></v-select>

            <field-messages name="sekolah_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Sekolah is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <validate tag="div">
          <div class="form-group">
            <label for="model-nilai_zona">Nilai Zona</label>
            <input type="text" class="form-control" id="model-nilai_zona" v-model="model.nilai_zona" name="nilai_zona" placeholder="Nilai Zona" required>
            <field-messages name="nilai_zona" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nilai Zona is a required field</small>
            </field-messages>
          </div>
        </validate>

          <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="user_id">Username</label>
            <v-select name="user_id" v-model="model.user" :options="user" class="mb-4"></v-select>

            <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

          <div class="form-row mt-4">
          <div class="col-md">
            <button type="submit" class="btn btn-primary">Submit</button>

            <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>
          </div>
        </div>

      </vue-form>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('api/zona/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {
          this.model.user = response.data.user;
          this.model.siswa = response.data.siswa;
          this.model.sekolah  = response.data.sekolah;
          this.model.zona_siswa  = response.data.zona.zona_siswa;
          this.model.zona_sekolah  = response.data.zona.zona_sekolah;
          this.model.lokasi_siswa  = response.data.zona.lokasi_siswa;
          this.model.lokasi_sekolah  = response.data.zona.lokasi_sekolah;
          this.model.nilai_zona  = response.data.zona.nilai_zona;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/zona/';
      }),
      axios.get('api/zona/create')
      .then(response => {           
          response.data.siswa.forEach(element => {
            this.siswa.push(element);
          });
          response.data.master_zona.forEach(element => {
            this.master_zona.push(element);
          });
          response.data.sekolah.forEach(element => {
            this.sekolah.push(element);
          });
          if(response.data.user_special == true){
            response.data.user.forEach(user_element => {
              this.user.push(user_element);
            });
          }else{
            this.user.push(response.data.user);
          }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/zona/';
      })
  },
  data() {
    return {
      state: {},
      model: {
        user : "",
        master_zona: "",
        siswa: "",
        sekolah: "",
        zona_siswa: "",
        zona_sekolah : "",
        lokasi_siswa: "",
        lokasi_sekolah : "",
        nilai_zona: "",
      },
      user: [],
      siswa: [],
      master_zona: [],
      sekolah: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/zona/' + this.$route.params.id, {
            user_id : this.model.user.id,
            nomor_un: this.model.siswa.nomor_un,
            siswa_id: this.model.siswa.id,
            sekolah_id : this.model.sekolah.id,
            zona_siswa : this.model.siswa.zona_siswa,
            zona_sekolah : this.model.sekolah.zona_sekolah,
            lokasi_siswa : this.model.siswa.lokasi_siswa,
            lokasi_sekolah : this.model.sekolah.lokasi_sekolah,
            nilai_zona : this.model.nilai_zona
          })
          .then(response => {
            if (response.data.status == true) {
              if(response.data.message == 'success'){
                alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert(response.data.message);
            }
          })
          .catch(function(response) {
            alert('Break ' + response.data.message);
          });
      }
    },
    reset() {
      axios.get('api/zona/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.nilai_zona  = response.data.zona.nilai_zona;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/zona';
    }
  }
}
</script>
