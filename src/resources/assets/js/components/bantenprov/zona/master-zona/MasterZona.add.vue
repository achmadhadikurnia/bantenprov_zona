<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Add Master Zona

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

        <validate tag="div">
          <div class="form-group">
            <label for="model-tingkat">Tingkat</label>
            <input type="text" class="form-control" id="model-tingkat" v-model="model.tingkat" name="tingkat" placeholder="Tingkat" required>
            <field-messages name="tingkat" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Tingkat is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-kode">Kode</label>
            <input type="text" class="form-control" id="model-kode" v-model="model.kode" name="kode" placeholder="Kode" required>
            <field-messages name="kode" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Kode is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-label">Label</label>
            <input type="text" class="form-control" id="model-label" v-model="model.label" name="label" placeholder="Label" required>
            <field-messages name="label" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Label is a required field</small>
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
  mounted(){
    axios.get('api/master-zona/create')
    .then(response => {
        if (response.data.status == true) {
        this.model.user = response.data.current_user;
        if(response.data.user_special == true){
        response.data.user.forEach(user_element => {
          this.user.push(user_element);
        });
      }else{
        this.user.push(response.data.user);
       }
      } else {
        alert('Failed');
      }
    })    
    .catch(function(response) {
      alert('Break');
    });
  },
  data() {
    return {
      state: {},
      model: {
        label: "",
        user: "",
        tingkat: "",
        kode: "",
      },
      user: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.post('api/master-zona', {
            label: this.model.label,
            tingkat: this.model.tingkat,
            kode: this.model.kode,
            user_id: this.model.user.id
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
      axios.get('api/master-zona/create')
        .then(response => {
          if (response.data.status == true) {
            this.model.tingkat  = response.data.master_zona.tingkat;
            this.model.kode  = response.data.master_zona.kode;
            this.model.label  = response.data.master_zona.label;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break');
          window.location.href = '#/admin/master-zona';
        });
    },
    back() {
      window.location = '#/admin/master-zona';
    }
  }
}
</script>
