<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <dl class="row">
          <dt class="col-4">Tingkat</dt>
          <dd class="col-8">{{ model.tingkat }}</dd>

          <dt class="col-4">Kode</dt>
          <dd class="col-8">{{ model.kode }}</dd>

          <dt class="col-4">Label</dt>
          <dd class="col-8">{{ model.label }}</dd>
      </dl>
    </div>

    <div class="card-footer text-muted">
      <div class="row">
        <div class="col-md">
          <b>Username :</b> {{ model.user.name }}
        </div>
        <div class="col-md">
          <div class="col-md text-right">Dibuat : {{ model.created_at }}</div>
          <div class="col-md text-right">Diperbarui : {{ model.updated_at }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2';

export default {
  data() {
    return {
      state: {},
      title: 'View Master Zona',
      model: {
        tingkat : '',
        kode    : '',
        label   : '',

        user    : [],
      },
    }
  },
  mounted() {
    let app = this;

    axios.get('api/master-zona/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.tingkat    = response.data.master_zona.tingkat;
          this.model.kode       = response.data.master_zona.kode;
          this.model.label      = response.data.master_zona.label;
          this.model.user_id    = response.data.master_zona.user_id;
          this.model.created_at = response.data.master_zona.created_at;
          this.model.updated_at = response.data.master_zona.updated_at;

          this.model.user       = response.data.master_zona.user;

          if (this.model.user === null) {
            this.model.user = {'id':this.model.user_id, 'name':''};
          }
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );

          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );

        app.back();
      });
  },
  methods: {
    back() {
      window.location = '#/admin/master-zona';
    }
  }
}
</script>