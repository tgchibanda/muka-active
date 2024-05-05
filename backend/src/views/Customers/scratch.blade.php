<form @submit.prevent="onSubmit">
                <div class="bg-white px-4 pt-5 pb-4">
                  <CustomInput class="mb-2" v-model="customer.first_name" label="First Name"/>
                  <CustomInput class="mb-2" v-model="customer.last_name" label="Last Name"/>
                  <CustomInput class="mb-2" v-model="customer.email" label="Email"/>
                  <CustomInput class="mb-2" v-model="customer.phone" label="Phone"/>
                  <CustomInput type="checkbox" class="mb-2" v-model="customer.status" label="Active"/>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                      <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Billing Address</h2>

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <CustomInput v-model="customer.billingAddress.address1" label="Address 1"/>
                        <CustomInput v-model="customer.billingAddress.address2" label="Address 2"/>
                        <CustomInput v-model="customer.billingAddress.city" label="City"/>
                        <CustomInput v-model="customer.billingAddress.zipcode" label="Zip Code"/>

                        <CustomInput type="select" :select-options="countries" v-model="customer.billingAddress.country_code" label="Country"/>
                        <CustomInput v-if="!billingCountry.states" v-model="customer.billingAddress.state" label="State"/>
                        <CustomInput v-else type="select" :select-options="billingStateOptions" v-model="customer.billingAddress.state" label="State"/>
                      </div>
                    </div>

                    <div>
                      <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Shipping Address</h2>

                      <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <CustomInput  v-model="customer.shippingAddress.address1" label="Address 1"/>
                        <CustomInput  v-model="customer.shippingAddress.address2" label="Address 2"/>
                        <CustomInput  v-model="customer.shippingAddress.city" label="City"/>
                        <CustomInput  v-model="customer.shippingAddress.zipcode" label="Zip Code"/>
                        <CustomInput type="select" :select-options="countries" v-model="customer.shippingAddress.country_code" label="Country"/>
                        <CustomInput v-if="!shippingCountry.states" v-model="customer.shippingAddress.state" label="State"/>
                        <CustomInput v-else type="select" :select-options="shippingStateOptions" v-model="customer.shippingAddress.state" label="State"/>
                      </div>
                    </div>
                  </div>

                </div>
                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button type="submit"
                          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                          text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                    Submit
                  </button>
                  <button type="button"
                          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                          @click="closeModal" ref="cancelButtonRef">
                    Cancel
                  </button>
                </footer>
              </form>