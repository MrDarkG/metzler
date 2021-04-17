<template>
	<div class="container">
		<div class=" row bg-white p-4 rounded">
			<div class="col-md-4 d-flex justify-content-center justify-content-xl-start">
				<div style="width:200px;">
					
					<croppa v-model="fileRecords"
			        	
				        	:src="imageUrl"
					        :width="200"
					        :height="200"
					        :canvas-color="'#00000001'"
					        :placeholder="'Chooes profile image'"
					        :placeholder-font-size="17"
					        :placeholder-color="'default'"
					        :accept="'image/*'"
					        :file-size-limit="0"
					        :quality="2"
					        :zoom-speed="7"
					        :disabled="false"
					        :disable-drag-and-drop="false"
					        :disable-click-to-choose="false"
					        :disable-drag-to-move="false"
					        :disable-scroll-to-zoom="false"
					        :disable-rotation="false"
					        :prevent-white-space="false"
					        :reverse-scroll-to-zoom="false"
					        :show-remove-button="true"
					        :remove-button-color="'red'"
					        :remove-button-size="0"
					        :input-attrs="{capture: true, class: 'file-input'}"
					        :initial-image="imageUrl"
					        @file-choose="onInputImage"
					        @move="ImageDataUrlGenerator"
					        @zoom="ImageDataUrlGenerator"
					        @image-remove="imageUrl = ''"
				        >
			        </croppa>
				</div>
			</div>
			<div class="col-md-8 row ml-0">
				<div class=" col-md-6 mt-xl-0 mt-2">
					<input type="email" placeholder="E-mail: *" class="form-control" id="email" v-model="email">
				</div>
				<div class=" col-md-6 mt-xl-0 mt-2">
					<input type="text" placeholder="Name: *" class="form-control" id="name" v-model="name">
				</div>
				<div class=" col-md-6 mt-xl-0 mt-2">
					<input type="text" placeholder="Surname"  class="form-control" id="surname" v-model="surname">
				</div>

				<div class=" col-md-6 mt-xl-0 mt-2">
					<input type="text" placeholder="Phone number"  class="form-control" id="number" v-model="phone">
				</div>
				<div class=" col-md-6 mt-xl-0 mt-2">
					<input type="password" placeholder="Password: *"  class="form-control" id="password" v-model="password">
				</div>
				<div class=" col-md-6 mt-xl-0 mt-2">
					<input type="password" placeholder="Password confirmation: *"  class="form-control" id="password-confirmation" v-model="password_confirmation">
				</div>
				<div class=" col-md-6 mt-xl-0 mt-2">
					<select class="form-control" id="role" v-model="role" >
						<option value="null">Pick A Role: *</option>
						<option value="admin">admin</option>
						<option value="writer">writer</option>
					</select>
				</div>
				<div class=" col-md-6 mt-xl-0 mt-2">
					<button class="btn btn-primary w-100" @click="saveuser()">save</button>
				</div>
			</div>

		</div>
	</div>
</template>
<script >
	import Vue from 'vue';
	import Croppa from 'vue-croppa'; 
	import VueToastify from "vue-toastify"

	import 'vue-croppa/dist/vue-croppa.css';
	Vue.use(VueToastify);
	Vue.use(Croppa);

	export default{

		data(){
			return {
				imageUrl:"",
				fileRecordsForUpload: {},
				fileRecords:{},
				email:"",
				name:"",
				surname:"",
				phone:"",
				password:"",
				password_confirmation:"",
				role:null
			}
			
		},
		watch: {
		    fileRecords: function (val) {
		    	if (val.length>0) {

		      		this.loadImage(val[0].urlResized);
		      		this.$modal.show('croppermodal')
		    	}
		      	
		    },
		    
		    
		    
		},
		methods:{
			clearinvalidfields(){
				let invalid_fields=document.getElementsByClassName("is-invalid");
				while (invalid_fields[0]) {
				    invalid_fields[0].classList.remove('is-invalid')
				}
				
			},
			saveuser(){
		      	this.ImageDataUrlGenerator();
				axios.post("/user/admin/store/user",{
					picture:this.imageUrl,
					email:this.email,
					name:this.name,
					surname:this.surname,
					phone:this.phone,
					password:this.password,
					password_confirmation:this.password_confirmation,
					role:this.role,

				}).then((data)=>{
					this.$vToastify.success(`post added successfully`,"Success")
					setTimeout(()=>{
							window.location.href=data.data
					}, 5000);
					
				})
				.catch(error=>{
					if(error.response.status==422){
						let errrors=error.response.data.errors;
						let keys=Object.keys(errrors)
						for (var i = 0; i < keys.length; i++) {
							
							this.$vToastify.error(`Please read errors carefully! ${errrors[keys[i]][0]} `,"Error!")
							document.getElementById(keys[i]).classList.add("is-invalid")
						}
						setTimeout(()=>{
							this.clearinvalidfields()
						}, 5000);

					}
					else{
						this.$vToastify.error(`We have Error in our system. Please contact support `,"Error!")

					}
				})
				
			},
			onInputImage(data){
				let reader = new FileReader()
			    reader.readAsDataURL(data)
			    reader.onload = (e)=> {
			      this.imageUrl= e.target.result
			    } 
			},
			ImageDataUrlGenerator(){
				this.imageUrl = this.fileRecords.generateDataUrl()
			},
			

		},
		mounted(){
        	this.$vToastify.setSettings({position:"bottom-left",errorDuration:5000});

		}
	};
</script>