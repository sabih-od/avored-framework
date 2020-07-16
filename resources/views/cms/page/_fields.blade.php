<div class="mt-3 flex w-full">
    <avored-input
        label-text="{{ __('avored::cms.page.name') }}"
        field-name="name"
        init-value="{{ $page->name ?? '' }}" 
        error-text="{{ $errors->first('name') }}"
    >
    </avored-input>
</div>
<div class="mt-3 flex w-full">
    <avored-input
        label-text="{{ __('avored::cms.page.slug') }}"
        field-name="slug"
        init-value="{{ $page->slug ?? '' }}" 
        error-text="{{ $errors->first('slug') }}"
    >
    </avored-input>
</div>



<div class="ant-row ant-form-item">
    <div class="ant-form-item-label">
        <label for="page-content" title="{{ __('avored::cms.page.content') }}">
            {{ __('avored::cms.page.content') }}
        </label>
    </div>
    
    <div class="ant-form-item-control-wrapper">
        <div class="ant-form-item-control">
            <quil-editor id="page-content" :options="editorOption" v-model="content"></quil-editor>
            <input type="hidden" name="content" v-model="content" />
        </div>
    </div>
</div>


<div class="mt-3 flex w-full">
    <avored-input
        label-text="{{ __('avored::cms.page.meta_title') }}"
        field-name="meta_title"
        init-value="{{ $menuGroup->meta_title ?? '' }}" 
        error-text="{{ $errors->first('meta_title') }}"
    >
    </avored-input>
</div>

<div class="mt-3 flex w-full">
    <avored-input
        label-text="{{ __('avored::cms.page.meta_description') }}"
        field-name="meta_description"
        init-value="{{ $menuGroup->meta_description ?? '' }}" 
        error-text="{{ $errors->first('meta_description') }}"
    >
    </avored-input>
</div>

<avored-modal modal-title="{{__('avored::cms.page.widget_modal_title') }}" @close="widgetModalVisible=false" :is-visible="widgetModalVisible">
    <div class="block">
        <avored-select
            label-text="Please Select Widget"
            field-name="selected_widget"
            v-model="selectedWidget"
            :options="{{ $widgets }}"
        >
        </avored-select>
        <div class="mt-3 py-3">
            <button type="button" @click="handleWidgetOk"
                class="px-3 py-2 text-white hover:text-white bg-red-600 rounded hover:bg-red-700"
            >   
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline-flex w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M0 2C0 .9.9 0 2 0h14l4 4v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5 0v6h10V2H5zm6 1h3v4h-3V3z"/>
                </svg>
                <span class="ml-3">Save</span>
            </button>
        </div>
    
    </div>
</avored-modal>
