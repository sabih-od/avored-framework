<div class="mt-3 rounded border">
    <div class="font-semibold border-b text-red-500 p-5 py-3">{{ __('avored::catalog.product.attribute_card_title') }}</div>
    <div class="p-5">

        <p>
            <a-form-item label="{{ __('avored::catalog.product.attribute_card_title') }}">
                <a-select @change="changeVariation" :default-value="attributeIds" mode="multiple"  placeholder="Please select">
                    @foreach ($attributes as $attribute)
                        <a-select-option :value="{{ $attribute->id }}" key="{{ $attribute->id }}">
                            {{ $attribute->name }}
                        </a-select-option>
                    @endforeach
                </a-select>
            </a-form-item>
            <div class="add-on-button">
                <button type="button" @click="handleVariationBtnClick" t
                    class="px-6 py-2 font-semibold leading-5 text-white hover:text-white bg-red-600 rounded hover:bg-red-700"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline-flex w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M0 2C0 .9.9 0 2 0h14l4 4v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5 0v6h10V2H5zm6 1h3v4h-3V3z"/>
                    </svg>
                    <span class="ml-3">{{ __('avored::catalog.product.variation_btn') }}</span>
                </button>
            </div>
        </p>

        <h4 class="my-4 text-xl text-red-500">{{ __('avored::catalog.product.variation_title') }}</h4>

        <avored-table :columns="columns" row-key="id" :items="productVariations">
            <template slot="variableProductName" slot-scope="{item}">
                @{{ item.variation.name }}
            </template>
            <template slot="variableProductPrice" slot-scope="{item}">
                @{{ item.variation.price }}
            </template>
            <template slot="variableProductQty" slot-scope="{item}">
                @{{ item.variation.qty }}
            </template>
            <template slot="variableProductAction" slot-scope="{item}">
                <div class="flex items-center">
                    <a href="javascript:;" @click="editVariationModel(item)">Edit</a>
                    <div class="px-2 text-gray-400">|</div>
                    <a href="javascript:;" @click="deleteVariation(item)">Delete</a>
                </div>
            </template>
        
        </avored-table>


        <avored-modal modal-title="{{__('avored::catalog.product.variation_model_title') }}" @close="variationModelVisible=false" :is-visible="variationModelVisible">
            <div class="block">
                <div class="flex items-center">
                    <div class="w-1/2">
                        <avored-input
                        label-text="{{ __('avored::system.fields.name') }}"
                        field-name="name"
                        :init-value="variationModel.name"
                        v-model="variationModel.name"
                        ></avored-input>
                    </div>
                    <div class="ml-3 w-1/2">
                        <avored-input
                        label-text="{{ __('avored::system.fields.slug') }}"
                        field-name="slug"
                        :init-value="variationModel.slug"
                        v-model="variationModel.slug"
                        ></avored-input>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <div class="w-1/2">
                        <avored-input
                        label-text="{{ __('avored::system.fields.sku') }}"
                        field-name="sku"
                        :init-value="variationModel.sku"
                        v-model="variationModel.sku"
                        ></avored-input>
                    </div>
                    <div class="ml-3 w-1/2">
                        <avored-input
                        label-text="{{ __('avored::system.fields.barcode') }}"
                        field-name="barcode"
                        :init-value="variationModel.barcode"
                        v-model="variationModel.barcode"
                        ></avored-input>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <div class="w-1/2">
                        <avored-input
                        label-text="{{ __('avored::system.fields.qty') }}"
                        field-name="qty"
                        :init-value="variationModel.qty"
                        v-model="variationModel.qty"
                        ></avored-input>
                    </div>
                    <div class="ml-3 w-1/2">
                        <avored-input
                        label-text="{{ __('avored::system.fields.price') }}"
                        field-name="price"
                        :init-value="variationModel.price"
                        v-model="variationModel.price"
                        ></avored-input>
                    </div>
                </div>
                <div class="flex mt-3 mb-5">
                    <div class="w-full">
                        <div class="block">
                            <label>{{ __('avored::catalog.product.variation_image') }}</label>
                            <a-upload
                                name="file"
                                :multiple="false"
                                :default-file-list="variationImageList"
                                :headers="headers"
                                :action="variationUploadImagePath" 
                                >
                                <a-button>
                                    <a-icon type="upload"></a-icon> {{ __('avored::catalog.product.variation_image_upload') }}
                                </a-button>
                            </a-upload>
                        </div>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <div class="w-1/4">
                        <avored-input
                        label-text="{{ __('avored::system.fields.weight') }}"
                        field-name="weight"
                        :init-value="variationModel.weight"
                        v-model="variationModel.weight"
                        ></avored-input>
                    </div>
                    <div class="ml-3 w-1/4">
                        <avored-input
                        label-text="{{ __('avored::system.fields.height') }}"
                        field-name="height"
                        :init-value="variationModel.height"
                        v-model="variationModel.height"
                        ></avored-input>
                    </div>
                    <div class="ml-3 w-1/4">
                        <avored-input
                        label-text="{{ __('avored::system.fields.width') }}"
                        field-name="width"
                        :init-value="variationModel.width"
                        v-model="variationModel.width"
                        ></avored-input>
                    </div>
                    <div class="ml-3 w-1/4">
                        <avored-input
                        label-text="{{ __('avored::system.fields.length') }}"
                        field-name="length"
                        :init-value="variationModel.length"
                        v-model="variationModel.length"
                        ></avored-input>
                    </div>
                </div>


                <div class="mt-3 py-3">
                    <button type="button" @click="clickVariationSave"
                        class="px-3 py-2 text-white hover:text-white bg-red-600 rounded hover:bg-red-700"
                    >   
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline-flex w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M0 2C0 .9.9 0 2 0h14l4 4v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5 0v6h10V2H5zm6 1h3v4h-3V3z"/>
                        </svg>
                        <span class="ml-3">{{__('avored::catalog.product.variation_save_btn') }}</span>
                    </button>
                </div>
            
            </div>
        </avored-modal>

       
    </div>

</div>
