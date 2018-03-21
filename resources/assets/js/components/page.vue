

<template>
<div class="container" style="margin-top: 100px">
  <div class="row">            
      <div class="col-md-12">
          <div class="form-group">
              <label for="name">Category name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter category name" v-model="inputName">
          </div>
          <div class="form-group">
              <label for="parent">Select category parent</label>
              <select class="form-control" v-model="inputParent">
                  <option value="0">- No parent -</option>
                  <option v-for="category in selectCategories" v-bind:value="category.id">{{ category.selectName }}</option>
              </select>
          </div>
          <button type="submit" class="btn btn-primary" v-on:click="addCategory">Submit</button>
      </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="form-check">
        <input class="form-check-input" type="radio" value="option1" v-model="type">
        <label class="form-check-label" for="type1">
          Using package functions
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" value="option2" v-model="type">
        <label class="form-check-label" for="type2">
          Custom iterative function
        </label>
      </div>      
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 m-t-50">
        <tree-menu v-for="category in categories" :name="category.name" :children="category.children" :id="category.id" :key="category.id" :deleteItem="deleteItem"></tree-menu>
    </div>
  </div>
</div>
</template>



<script>
  export default {
     data: function() {
        return {
          type: 'option1',
          categories: [],
          selectCategories: [],
          inputName: '',
          inputParent: 0,
        }
      },
      filters: {
        
      },
      methods: {
        deleteItem: function(id, name){
          var r = confirm("Are you sure you want to delete "+name+" category?\nThis will delete all of its childs");
          if (r == true) {
            let vm = this;
            axios.get('/api/remove/category', {
              params: {
                id: id
              }
            }).then(function (response) {
              if (response.data) {
                vm.reloadCategories();
                vm.showNotification(response.data[0], response.data[1], response.data[2]);
              }
            }).catch(function (error) {
              vm.showErrorMessage();
            });
          }
        },
        flat: function(items) {
            var final = []
            var self = this

            $.map(items, function(item, index){
                var dash = '- ';
                dash = dash.repeat(item.depth);
                item.selectName = dash + item.name;
                final.push(item)
                if (typeof item.children !== 'undefined') {
                    final = final.concat(self.flat(item.children));
                }
            });
            return final;
        },
        showNotification: function(color, icon, text){
            var notification = new NotificationFx({
                message : '<span class="'+color+' fa fa-'+icon+'"></span><p>'+text+'</p>',
                layout : 'bar',
                effect : 'slidetop',
                type : 'notice', // notice, warning or error
                ttl : 3000,
            });            
            notification.show();
        },
        showErrorMessage: function(){
          this.showNotification('red', 'exclamation', 'Something went wrong...');
        },
        addCategory: function(){
          if (this.inputName.length == 0){
            this.showNotification('red', 'exclamation', 'You probably forgot to enter category name');
          } else {
            let vm = this;
            axios.get('/api/add/category', {
              params: {
                parent: vm.inputParent,
                name: vm.inputName
              }
            }).then(function (response) {
              if (response.data){
                vm.inputName = '';
                vm.reloadCategories();
                vm.showNotification(response.data[0], response.data[1], response.data[2]);                
              } else {
                vm.showErrorMessage();
              }
            }).catch(function (error) {
              vm.showErrorMessage();
            });
            
          }
        },
        reloadCategories: function() {
          let vm = this;
          axios.get('/api/get/categories', {
            params: {
              type: vm.type
            }
          }).then(function (response) {
            if (response.data) {
              vm.categories = response.data;
              vm.selectCategories = vm.flat(vm.categories)
            } else {
              vm.showErrorMessage();
            }
          }).catch(function (error) {
            vm.showErrorMessage();
          });
        }
      },
      mounted(){        
        this.reloadCategories();
      },
      watch: {
        type: function() {
          this.categories = [];
          this.selectCategories = [];
            this.reloadCategories();
        }
      }
    }
</script>
