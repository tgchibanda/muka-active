import axiosClient from "../axios";

export function getUser({commit}, data) {
  return axiosClient.get('/user', data)
    .then(({data}) => {
      commit('setUser', data);
      return data;
    })
}


export function login({commit}, data) {
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user);
      commit('setToken', data.token)
      return data;
    })
}

export function logout({commit}) {
  return axiosClient.post('/logout')
    .then((response) => {
      commit('setToken', null)

      return response;
    })
}

export function getCountries({commit}) {
  return axiosClient.get('countries')
    .then(({data}) => {
      //console.log(data)
      commit('setCountries', data)
    })
}

export function getProducts({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setProducts', [true])
  url = url || '/products'
  const params = {
    per_page: state.products.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setProducts', [false, response.data])
    })
    .catch(() => {
      commit('setProducts', [false])
    })
}

export function getUsers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setUsers', [true])
  url = url || '/users'
  const params = {
    per_page: state.users.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setUsers', [false, response.data])
    })
    .catch(() => {
      commit('setUsers', [false])
    })
}

export function getCustomers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setCustomers', [true])
  url = url || '/customers'
  const params = {
    per_page: state.customers.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setCustomers', [false, response.data])
    })
    .catch(() => {
      commit('setCustomers', [false])
    })
}


export function getOrders({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setOrders', [true])
  url = url || '/orders'
  const params = {
    per_page: state.orders.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setOrders', [false, response.data])
      console.log(response.data) // Delete this
    })
    .catch(() => {
      commit('setOrders', [false])
    })
}

export function createProduct({commit}, product) {
  if (product.images && product.images.length) {
    const form = new FormData();
    form.append('title', product.title);
    form.append('weight', product.weight);
      // Append colors as an array
      product.value.product_color.forEach(color => {
        form.append('product_color[]', color); // '[]' to indicate multiple values
      });
    product.images.forEach(im => form.append('images[]', im))
    form.append('description', product.description || '');
    form.append('published', product.published ? 1 : 0);
    form.append('price', product.price);
    product = form;
  }
  return axiosClient.post('/products', product)
}

export function  createUser({commit}, user) {
  return axiosClient.post('/users', user)
}

export function  createCustomer({commit}, customer) {
  return axiosClient.post('/customers', customer)
}

export function updateProduct({commit}, product) {
  const id = product.id
  if (product.images && product.images.length) {
    const form = new FormData();
    form.append('id', product.id);
    form.append('title', product.title);
    form.append('weight', product.weight);
    // Append colors as an array
    product.value.product_color.forEach(color => {
      form.append('product_color[]', color); // '[]' to indicate multiple values
    });
    product.images.forEach(im => form.append(`images[${im.id}]`, im))
    if (product.deleted_images) {
      product.deleted_images.forEach(id => form.append('deleted_images[]', id))
    }
    for (let id in product.image_positions) {
      form.append(`image_positions[${id}]`, product.image_positions[id])
    }
    form.append('description', product.description || '');
    form.append('published', product.published ? 1 : 0);
    form.append('price', product.price);
    form.append('_method', 'PUT');
    product = form;
  } else {
    product._method = 'PUT'
  }
  return axiosClient.post(`/products/${id}`, product)
}

export function updateUser({commit}, user) {
  return axiosClient.put(`/users/${user.id}`, user)
}

export function updateCustomer({commit}, customer) {
  return axiosClient.put(`/customers/${customer.user_id}`, customer)
}

export function deleteProduct({commit}, id) {
  return axiosClient.delete(`/products/${id}`)
}

export function deleteUser({commit}, id) {
  return axiosClient.delete(`/users/${id}`)
}

export function deleteCustomer({commit}, id) {
  return axiosClient.delete(`/customers/${id}`)
}

export function getProduct({}, id) {
  return axiosClient.get(`/products/${id}`)
}

export function getCustomer({}, user_id) {
  return axiosClient.get(`/customers/${user_id}`)
}

export function getOrder({}, id) {
  return axiosClient.get(`/orders/${id}`)
}

export function getCategories({commit, state}, {url = null, per_page, sort_field, sort_direction} = {}) {
    commit('setCategories', [true])
    url = url || '/categories'
    const params = {
      per_page: state.categories.limit,
    }
    return axiosClient.get(url, {
      params: {
        ...params,
        per_page, sort_field, sort_direction
      }
    })
      .then((response) => {
        commit('setCategories', [false, response.data])
      })
      .catch(() => {
        commit('setCategories', [false])
      })
  }

export function  createCategory({commit}, category) {
  return axiosClient.post('/categories', category)
}

export function updateCategory({commit}, category) {
  return axiosClient.put(`/categories/${category.id}`, category)
}

export function deleteCategory({commit}, id) {
  return axiosClient.delete(`/categories/${id}`)
}