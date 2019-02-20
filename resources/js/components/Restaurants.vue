<template>
	<div class="row">
		<div class="col-12 mb-2">
			<form class="form-wrap">
				<div class="form-group row">
					<div class="col-md-6 mb-2">
						<select class="form-control" name="sortby" v-model="sortby" v-on:change="getRestaurants">
							<option value="best_match" :selected="sortby == 'best_match'">Best Match</option>
							<option value="newest" :selected="sortby == 'newest'">Newest</option>
							<option value="rating_average" :selected="sortby == 'rating_average'">Rating Average</option>
							<option value="distance" :selected="sortby == 'distance'">Distance</option>
							<option value="popularity" :selected="sortby == 'popularity'">Popularity</option>
							<option value="average_product_price" :selected="sortby == 'average_product_price'">Average Product Price</option>
							<option value="delivery_costs" :selected="sortby == 'delivery_costs'">Delivery Costs</option>
							<option value="minimum_costs" :selected="sortby == 'minimum_costs'">Minimum Costs</option>
							<option value="top_restaurants" :selected="sortby == 'top_restaurants'">Top Restaurants</option>
						</select>
					</div>
					<div class="col-md-6 mb-2">
						<input type="text" placeholder="Search..." class="form-control" name="search" v-model="search" v-on:keyup="getRestaurants">
					</div>
				</div>
			</form>
		</div>
		<div class="row col-12">
			<div class="lds-heart" v-if="loading == true"><div></div></div>
			<div class="col-md-4 featured-responsive" v-for="restaurant in restaurants">
				<div class="featured-place-wrap">
					<img :src="restaurant.image" class="img-fluid" alt="#">
					<span :class="getRestaurantRatingClass(restaurant)">{{ restaurant.sortingValues.ratingAverage.toFixed(1) }}</span>
					<div class="featured-title-box">
						<h6>{{ restaurant.name }}</h6>
						<p>Restaurant </p>
						<span>• </span>
						<p v-if="sortby == 'minimum_costs'">min. <span>{{ (restaurant.sortingValues.minCost / 1000).toFixed(1) }} $</span></p>
						<p v-if="sortby != 'minimum_costs'">min. {{ (restaurant.sortingValues.minCost / 1000).toFixed(1) }} $</p>
						<span> • </span>
						<p v-if="sortby == 'distance'"><span>{{ (restaurant.sortingValues.distance / 1000).toFixed(1) }}</span> km</p>
						<p v-if="sortby != 'distance'">{{ (restaurant.sortingValues.distance / 1000).toFixed(1) }} km</p>
						<ul>
							<li>
								<span class="icon-calendar"></span>
								<p v-if="sortby == 'newest'"><span>Newest: {{ restaurant.sortingValues.newest }}</span></p>
								<p v-if="sortby != 'newest'">Newest: {{ restaurant.sortingValues.newest }}</p>
							</li>
							<li>
								<span class="icon-star"></span>
								<p v-if="sortby == 'popularity'"><span>Popularity: {{ restaurant.sortingValues.popularity.toFixed(1) }}</span></p>
								<p v-if="sortby != 'popularity'">Popularity: {{ restaurant.sortingValues.popularity.toFixed(1) }}</p>
							</li>
							<li>
								<span class="icon-diamond"></span>
								<p v-if="sortby == 'average_product_price'"><span>Average Product Price: {{ restaurant.sortingValues.averageProductPrice }}</span></p>
								<p v-if="sortby != 'average_product_price'">Average Product Price: {{ restaurant.sortingValues.averageProductPrice }}</p>
							</li>
							<li>
								<span class="icon-basket"></span>
								<p v-if="sortby == 'delivery_costs'"><span>Delivery Costs: {{ restaurant.sortingValues.deliveryCosts }}</span></p>
								<p v-if="sortby != 'delivery_costs'">Delivery Costs: {{ restaurant.sortingValues.deliveryCosts }}</p>
							</li>
						</ul>
						<div class="bottom-icons">
							<div :class="getRestaurantStatusClass(restaurant)">{{ getRestaurantStatus(restaurant) }}</div>
							<span class="fas fa-heart" v-if="restaurant.sortingValues.isFavorited == 1" v-on:click="unfavorite(restaurant)"></span>
							<span class="far fa-heart" v-if="restaurant.sortingValues.isFavorited == 0" v-on:click="favorite(restaurant)"></span>
						</div>
					</div>
				</div>
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
				sortby: 'best_match',
				search: '',
				loading: true,
                restaurants: []
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
			
			this.loading = false;
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
				if($cookies.get("favoritedRestaurants") == null)
					$cookies.set("favoritedRestaurants", "");
			
                this.getRestaurants();
            },
						
			getRestaurantRatingClass: function(restaurant){
				var html_class = "featured-rating";
				
				if(restaurant.sortingValues.ratingAverage >= 4)
					html_class += "-green";
				
				else if(restaurant.sortingValues.ratingAverage >= 3)
					html_class += "-orange";
				
				return html_class;
			},
			
			getRestaurantStatusClass: function(restaurant){
				var html_class = '';
				
				switch(restaurant.status){
					case 'open':
					case 'closed':
						html_class = restaurant.status + '-now';
						
						break;
					default:
						html_class = restaurant.status.replace(' ', '-');
						
						break;
				}			
				
				return html_class;
			},
			
			getRestaurantStatus: function(restaurant){
				var status = '';
				
				switch(restaurant.status){
					case 'open':
					case 'closed':
						status = restaurant.status.toUpperCase() + ' NOW';
						
						break;
					default:
						status = restaurant.status.toUpperCase();
						
						break;
				}			
				
				return status;
			},

            /**
             * Get all of the restaurants for listing.
             */
            getRestaurants() {
				this.loading = true;
			
                axios.get('/api/restaurants?sortby='+this.sortby+'&search='+this.search)
                    .then(response => {
                        this.restaurants = response.data;
						
						if(this.search)
							$('input[name="search"]').focus();
						
						this.loading = false;
                    });
            },					
			
			favorite(restaurant){
                axios.post('/api/restaurants/favorite', {
					restaurant: restaurant
				}).then(response => {
					this.getRestaurants();
					
					this.$toastr.s(response.data.success);
				}, error => {
					this.$toastr.e(error.response.data.error);
				});
			},
			
			unfavorite(restaurant){
                axios.post('/api/restaurants/unfavorite', {
					restaurant: restaurant
				}).then(response => {
					this.getRestaurants();
					
					this.$toastr.s(response.data.success);
				}, error => {
					this.$toastr.e(error.response.data.error);
				});
			}
        }
    }
</script>
