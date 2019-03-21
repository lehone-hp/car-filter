<form action="{{ route('listing') }}" method="GET" id="listingFilterForm">
                    <div class="sidebar-widget d-none d-lg-block">
                        <div class="card c-brd-light border-top-0">
                            <div class="c-bg-light">
                                <div class="card-body p-3">
                                    <a href="#" class="d-block text-btn c-montserrat c-dark c-font-weight-500" data-toggle="collapse" data-target="#demo3">Budget</a>
                                </div>
                            </div>
                            <div id="demo3" class="collapse show widget-content">
                                <div class="card-body py-4 bg-white text-center">
                                    <div class="mt-3 budget">
                                        <input id="sl2" data-ui-slider="" type="text" value="" name="budget"
                                               data-slider-min="500000" data-slider-max="100000000"
                                               data-slider-value="[{{ $search['budget_low'] ?: '500000' }},{{ $search['budget_high'] ?: '100000000' }}]" class="slider">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card c-brd-light border-top-0">
                            <div class="c-bg-light">
                                <div class="card-body p-3">
                                    <a href="#" class="d-block text-btn c-montserrat c-dark c-font-weight-500" data-toggle="collapse" data-target="#demo4">Brand Or Model</a>
                                </div>
                            </div>
                            <div id="demo4" class="collapse show widget-content">
                                <div class="card-body py-4 bg-white">
                                    <div class="form-group position-relative">
                                        <input type="text" class="form-control" name="q" value="{{ $search['q'] ?: '' }}"
                                               placeholder="e.g. Mustang or Ford Mustang">
                                        <div class="search position-absolute">
                                            <a onclick="$('#listingFilterForm').submit();" href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    @foreach(\App\Brand::all() as $brand)

                                        <div class="form-group">
                                            <input type="checkbox" name="brand[]" {{ in_array($brand->id, $search['brand']) ? 'checked' : '' }}
                                                   value="{{ $brand->id }}" id="{{ 'brand_'.$brand->id }}">
                                            <label for="{{ 'brand_'.$brand->id }}" class="mb-0">{{ $brand->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card c-brd-light border-top-0">
                            <div class="c-bg-light">
                                <div class="card-body p-3">
                                    <a href="#" class="d-block text-btn c-montserrat c-dark c-font-weight-500" data-toggle="collapse" data-target="#demo5">Make Year</a>
                                </div>
                            </div>
                            <div id="demo5" class="collapse show widget-content">
                                <div class="card-body py-4 bg-white">
                                    <div class="row">
                                        @for ($i = 0; $i < 20; $i++)
                                            <div class="form-group col-4">
                                                <input type="checkbox" name="year[]"  {{ in_array(\Carbon\Carbon::now()->year-$i, $search['year']) ? 'checked' : '' }}
                                                       id="{{ 'year_'.(\Carbon\Carbon::now()->year - $i) }}"
                                                       value="{{ \Carbon\Carbon::now()->year - $i }}">
                                                <label for="{{ 'year_'.(\Carbon\Carbon::now()->year - $i) }}"
                                                       class="mb-0">{{ \Carbon\Carbon::now()->year - $i }}</label>
                                            </div>
                                        @endfor
                                            <div class="form-group col-4">
                                                <input type="checkbox" name="year[]" {{ in_array(0, $search['year']) ? 'checked' : '' }}
                                                       id="year_0" value="0">
                                                <label for="year_0" class="mb-0"> < {{ \Carbon\Carbon::now()->year - 19 }}</label>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card c-brd-light border-top-0">
                            <div class="c-bg-light">
                                <div class="card-body p-3">
                                    <a href="#" class="d-block text-btn c-montserrat c-dark c-font-weight-500" data-toggle="collapse" data-target="#demo6">Kilometers Driven</a>
                                </div>
                            </div>
                            <div id="demo6" class="collapse show widget-content">
                                <div class="card-body py-4 bg-white text-center">
                                    <div class="mt-3 driven">
                                        <input id="sl3" name="driven" data-ui-slider="" type="text" value=""
                                               data-slider-min="0" data-slider-max="8000"
                                               data-slider-value="[{{ $search['driven_low'] ?: '0' }},{{ $search['driven_high'] ?: '8000' }}]" class="slider">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card c-brd-light border-top-0">
                            <div class="c-bg-light">
                                <div class="card-body p-3">
                                    <a href="#" class="d-block text-btn c-montserrat c-dark c-font-weight-500" data-toggle="collapse" data-target="#demo7">Fuel Type</a>
                                </div>
                            </div>
                            <div id="demo7" class="collapse show widget-content">
                                <div class="card-body py-4 bg-white">
                                    @foreach(\App\FuelType::all() as $fuel)
                                    <div class="form-group">
                                        <input type="checkbox" name="fuel[]" {{ in_array($fuel->id, $search['fuel']) ? 'checked' : '' }}
                                               value="{{ $fuel->id }}" id="{{ 'fuel_'.$fuel->id }}">
                                        <label for="{{ 'fuel_'.$fuel->id }}" class="mb-0">{{ $fuel->name }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card c-brd-light border-top-0">
                            <div class="c-bg-light">
                                <div class="card-body p-3">
                                    <a href="#" class="d-block text-btn c-montserrat c-dark c-font-weight-500" data-toggle="collapse" data-target="#demo8">Transmission</a>
                                </div>
                            </div>
                            <div id="demo8" class="collapse show widget-content">
                                <div class="card-body py-4 bg-white">
                                    <div class="form-group">
                                        <input type="checkbox" value="automatic" {{ in_array('automatic', $search['transmission']) ? 'checked' : '' }}
                                               name="transmission[]" id="transmission_auth">
                                        <label for="transmission_auth" class="mb-0">Automatic</label>
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="checkbox" value="manual" {{ in_array('manual', $search['transmission']) ? 'checked' : '' }}
                                        name="transmission[]" id="transmission_man">
                                        <label for="transmission_man" class="mb-0">Manual</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-md btn-block text-uppercase">Search</button>
                        </div>
                    </form>
