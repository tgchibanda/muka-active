export function setUser(state, user) {
    state.user.data = user;
}

export function setCustomer(state, customer) {
    state.customer.data = customer;
}

export function setToken(state, token) {
    state.user.token = token;
    if (token){
        sessionStorage.setItem('TOKEN', token)
    } else {
        sessionStorage.removeItem('TOKEN');
    }
}

export function setProducts(state, [loading, response = null]) {
    if(response){
        state.products = {
            data: response.data,
            links: response.meta.links,
            total: response.meta.total,
            limit: response.meta.per_page,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,

        }
    }
    state.products.loading = loading;
}

export function setUsers(state, [loading, response = null]) {
    if(response){
        state.users = {
            data: response.data,
            links: response.meta.links,
            total: response.meta.total,
            limit: response.meta.per_page,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,

        }
    }
    state.users.loading = loading;
}

export function setCustomers(state, [loading, response = null]) {
    if(response){
        state.customers = {
            data: response.data,
            links: response.meta.links,
            total: response.meta.total,
            limit: response.meta.per_page,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,

        }
    }
    state.users.loading = loading;
}

export function setOrders(state, [loading, response = null]) {
    if(response){
        state.orders = {
            data: response.data,
            links: response.meta.links,
            total: response.meta.total,
            limit: response.meta.per_page,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,

        }
    }
    state.orders.loading = loading;
}

export function showToast(state, message) {
    state.toast.show = true;
    state.toast.message = message;
  }
  
  export function hideToast(state) {
    state.toast.show = false;
    state.toast.message = '';
  }
  export function setCountries(state, countries) {
    state.countries = countries.data;
  }