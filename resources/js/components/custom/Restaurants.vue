<template>
	<div class="row">
		<div class="col-md-4 featured-responsive" v-for="restaurant in restaurants">
			<div class="featured-place-wrap">
				<a href="#">
					<img :src="randomImage()" class="img-fluid" alt="#">
					<span class="featured-rating">{{ restaurant.sortingValues.ratingAverage }}</span>
					<div class="featured-title-box">
						<h6>{{ restaurant.name }}</h6>
						<p>Restaurant </p> <span>• </span>
						<p>min. <span>{{ restaurant.sortingValues.minCost }} $</span></p> <span> • </span>
						<p><span>{{ restaurant.sortingValues.distance }}</span> meters</p>
						<ul>
							<li>
								<span class="icon-location-pin"></span>
								<p>{{ restaurant.address }}</p>
							</li>
							<li>
								<span class="icon-screen-smartphone"></span>
								<p>{{ restaurant.telephone }}</p>
							</li>
							<li>
								<span class="icon-link"></span>
								<p>{{ restaurant.url }}</p>
							</li>
						</ul>
						<div class="bottom-icons">
							<div :class="getRestaurantStatusClass(restaurant.status)">{{ getRestaurantStatus(restaurant.status) }}</div>
							<span class="ti-heart"></span>
							<span class="ti-bookmark"></span>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                restaurants: []
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getRestaurants();
            },
			
			randomInt: function(max){
				return Math.floor(Math.random() * Math.floor(max));
			},
						
			randomImage: function(){
				return "images/featured" + (this.randomInt(4) + 1) + ".jpg";
			},
			
			getRestaurantStatusClass: function(status){
				var html_class = '';
				
				switch(status){
					case 'open':
					case 'closed':
						html_class = status + '-now';
						
						break;
					default:
						html_class = status.replace(' ', '-');
						
						break;
				}			
				
				return html_class;
			},
			
			getRestaurantStatus: function(status){
				switch(status){
					case 'open':
					case 'closed':
						status = status.toUpperCase() + ' NOW';
						
						break;
					default:
						status = status.toUpperCase();
						
						break;
				}			
				
				return status;
			},

            /**
             * Get all of the restaurants for listing.
             */
            getRestaurants() {
                axios.get('/api/restaurants')
                    .then(response => {
                        this.restaurants = response.data;
                    });
            }
        }
    }
</script>
