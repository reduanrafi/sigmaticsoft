const app = {

    data() {
        return {
            message:'',
             rootUrl:'http://localhost:81/sigmaticsoft/ecomtic',
            // rootUrl:'http://ettabashop.com/',
            cartItems: [],
            cartTotal:0,
            netTotal:0,

            //cartTotalBn:this.changeNumberToBangla(this.cartTotal),
            deliveryCharge:1,
            paymentMethodId:0,

            emptyStar:"far fa-star",
            filledStar:"fas fa-star",
            star1:"far fa-star",
            star2:"far fa-star",
            star3:"far fa-star",
            star4:"far fa-star",
            star5:"far fa-star",
            rating:0,
            ratingText:"",
            orderSuccess:false

        }

    },
    methods: {
        addToCart(product_id, product_name,price,product_image)
        {
            let found = false;

            itemToAdd = {
                'product_id': product_id,

                'image': product_image,
                'name': product_name,
                'price': price,
                'quantity': 1
            };
            console.log(itemToAdd)

            // Add the item or increase qty

            let itemInCart = this.cartItems.filter(item => item.product_id === itemToAdd.product_id);

            let isItemInCart = itemInCart.length > 0;

            if (isItemInCart === false)
            {
                this.cartItems.push(itemToAdd);
            }
            else
            {
                itemInCart[0].quantity += 1;
                console.log( itemInCart[0].quantity )
            }

            localStorage.setItem('cartItems', JSON.stringify(this.cartItems));

            this.setTotal(this.calculateTotal())


        },

        removeItem(index) {

            this.cartItems.splice(index, 1);

            localStorage.setItem('cartItems', JSON.stringify(this.cartItems));

            this.setTotal(this.calculateTotal())

        },
        clearCart(){
            this.cartItems = [];
            localStorage.clear();
            this.cartTotal = 0;

        },
        calculateTotal(){
            let items = JSON.parse(localStorage.getItem('cartItems'));
            let total = [];

            total['price'] = 0;


            items.forEach(item => {

                total['price'] += item.price * item.quantity;


            });

            return total;
        },

        setTotal(total)
        {
            this.cartTotal = total['price'];
            this.netTotal = this.cartTotal;

        },

        calculateTotalTrp(){
            let items = JSON.parse(localStorage.getItem('cartItems'));
            let totalTrp = 0;
            items.forEach(item => {
                totalTrp +=  item.trp * item.quantity;
            });

            return totalTrp;
        },
        selectPaymentMethod(pmId){
            this.paymentMethodId = pmId;
            console.log(this.paymentMethodId)
        },

        saveOrder(userId,address,total){
            if (this.paymentMethodId==0)
            {
                this.message='Please select a payment method';
            }

            else{
                let order={
                    'order':{
                        "user_id":userId,
                        "payment_method_id":this.paymentMethodId,
                        "address_id":1,
                        "orderItems":this.cartItems
                    }

                }

                //console.log(order)


                    axios.post(this.rootUrl+"orders/save", order)
                        .then(response => {

                            console.log(response);
                            this.message=response.data.message

                        }).catch(error => console.log(error.response));
                this.orderSuccess=true;
                this.clearCart()
            }


        },

        save(order) {

            var csrf_token = document.querySelector('input[name="_token"]').getAttribute('value');
            //console.log(csrf_token)
            fetch(this.rootUrl + "orders/save/", {
                _method: 'post',

                body: JSON.stringify(order),
                headers: {
                    "Content-Type": "application/json",

                },


            }).then(response => {
                if (response.ok) {
                    alert("order saved successfully!")
                    return response.json()
                } else {
                    alert("Server returned " + response.status + " : " + response.statusText);
                }
            }).catch(err => {
                console.log(err);
            });
        },

        timeSince: function (date) {

            if (date != undefined) {

                var seconds = Math.floor((new Date() - this.sqlToJS(date)) / 1000);

                ////console.log(date)
                var interval = Math.floor(seconds / 31536000);

                if (interval > 1) {
                    return interval + " years";
                }
                interval = Math.floor(seconds / 2592000);
                if (interval > 1) {
                    return interval + " months";
                }
                interval = Math.floor(seconds / 86400);
                if (interval > 1) {
                    return interval + " days";
                }
                if (interval == 1) {

                    return interval + " day";
                }
                interval = Math.floor(seconds / 3600);
                if (interval > 1) {
                    return interval + " hours";
                }
                interval = Math.floor(seconds / 60);
                if (interval > 1) {
                    return interval + " minutes";
                }
                return Math.floor(seconds) + " seconds";
            }

        },
        changeNumberToBangla(n)
        {
            console.log(n)
            const toBn = n => n.replace(/\d/g, d => "০১২৩৪৫৬৭৮৯"[d]);

            return toBn(n)
        },
        ratingUpdate(rating)
        {
            this.rating =rating;
            this.changeClass(rating)

        },
        saveRating()
        {

            console.log(this.rating)
            console.log(this.ratingText)
        },

        changeClass(){

            if (this.rating==0)
            {
                this.star1 = this.emptyStar;
                this.star2 = this.emptyStar;
                this.star3 = this.emptyStar;
                this.star4 = this.emptyStar;
                this.star5 = this.emptyStar;
            }
            else if (this.rating==1)
            {
                this.star1 = this.filledStar;
                this.star2 = this.emptyStar;
                this.star3 = this.emptyStar;
                this.star4 = this.emptyStar;
                this.star5 = this.emptyStar;
            }
            else if (this.rating==2)
            {
                this.star1 = this.filledStar;
                this.star2 = this.filledStar;
                this.star3 = this.emptyStar;
                this.star4 = this.emptyStar;
                this.star5 = this.emptyStar;
            }
            else  if (this.rating==3)
            {
                this.star1 = this.filledStar;
                this.star2 = this.filledStar;
                this.star3 = this.filledStar;
                this.star4 = this.emptyStar;
                this.star5 = this.emptyStar;
            }
            else  if (this.rating==4)
            {
                this.star1 = this.filledStar;
                this.star2 = this.filledStar;
                this.star3 = this.filledStar;
                this.star4 = this.filledStar;
                this.star5 = this.emptyStar;
            }
            else if (this.rating==5)
            {
                this.star1 = this.filledStar;
                this.star2 = this.filledStar;
                this.star3 = this.filledStar;
                this.star4 = this.filledStar;
                this.star5 = this.filledStar;
            }
        }
    },
    mounted: function () {

        if (localStorage.getItem('cartItems')!='undefined' && localStorage.getItem('cartItems')!=null) {

            this.cartItems = JSON.parse(localStorage.getItem('cartItems'));
            this.cartTotal = this.Total['erp'];
            this.trp = this.Total['trp'];
            this.tcb = this.Total['tcb'];
            this.rateTotal = this.Total['rate'];
            this.netTotal = this.cartTotal-this.tcb;
        }

    },
    computed: {
        Total() {
            console.log(localStorage.getItem('cartItems'))
            if (localStorage.getItem('cartItems')!='undefined' && localStorage.getItem('cartItems')!=null) {
                let items = JSON.parse(localStorage.getItem('cartItems'));

                let total = [];

                total['erp'] = 0;
                total['trp'] = 0;
                total['tcb'] = 0;
                total['rate'] = 0;

                items.forEach(item => {
                    total['erp'] += item.price * item.quantity;
                    total['trp'] +=  item.trp * item.quantity;
                    total['tcb'] +=  item.tcb * item.quantity;
                    total['rate'] +=  item.rate * item.quantity;
                });
                if(items.length>0)
                {
                    total['erp']+=this.deliveryCharge;

                }
                return  total;
            }

        },

    },

};

Vue.createApp(app).mount('#app')