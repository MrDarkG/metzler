<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="form-group col-md-12">
	            <input id="title" type="text" class="form-control" name="title" required autofocus placeholder="Title" v-model="title">
	        </div>
	        <div class="col-md-12 row justify-content-between">
	        	<div style="width:308px;">
					<croppa v-model="fileRecords"
		        	
			        	:src="imageUrl"
				        :width="308"
				        :height="196"
				        :canvas-color="'white'"
				        :placeholder="'Chooes image for post cover'"
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
	        	<div class="create-content">
	        		
		            <textarea id="content" type="text" class="form-control" name="content" required autofocus placeholder="Content" v-model="content">
		            </textarea>
	        	</div>
	            
	        </div>
	        
	        <div class="form-group col-md-12 mt-2">
	        	<button class="btn btn-primary w-100" @click="createpost()">save</button>
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
				title:"",
				content:""
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
			createpost(){
		      this.ImageDataUrlGenerator();
				
				axios.post("/user/save/post",{
					content:this.content,
					title:this.title,
					cover:this.imageUrl

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