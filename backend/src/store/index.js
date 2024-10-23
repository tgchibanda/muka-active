import {createStore} from "vuex";
import * as actions from './actions';
import * as mutations from './mutations';
import state from './state';


const store = createStore({
  state: state,
  getters: {},
  actions,
  mutations,
})

export default store
