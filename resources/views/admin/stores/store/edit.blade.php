@extends('layouts.admin.store') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')

                   <form method="post" action="{{ route('adminStorePanel.update', $id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label for="store_title" class="col-md-4 col-form-label text-md-right">{{ __('Store Name *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                               <input id="store_title" type="text" class="form-control @error('store_title') is-invalid @enderror" name="store_title" value="{{ old('store_title') }}" required autocomplete="store_title" autofocus>                         
                              @else
                                <input id="store_title" type="text" class="form-control @error('store_title') is-invalid @enderror" name="store_title" value="{{ $storeInfo->store_title }}" required autocomplete="store_title" autofocus>                         
                              @endif
                                @error('store_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   
                        
                        <div class="form-group row">
                            <label for="store_description" class="col-md-4 col-form-label text-md-right">{{ __('Store Description') }}</label>

                            <div class="col-md-6">
                                @if($errors->any())
                                  <textarea class="form-control @error('store_description') is-invalid @enderror" aria-label="store_description" name="store_description" id="store_description" autocomplete="store_description" autofocus>{{ old('store_description') }}</textarea>
                                @else
                                   <textarea class="form-control @error('store_description') is-invalid @enderror" aria-label="store_description" name="store_description" id="store_description" autocomplete="store_description" autofocus>{{ $storeInfo->store_description }}</textarea>
                                @endif
                                @error('store_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                           
                        
                        <div class="form-group row">
                            <label for="store_email" class="col-md-4 col-form-label text-md-right">{{ __('Store E-Mail *') }}</label>

                            <div class="col-md-6">
                               @if($errors->any())
                                 <input id="store_email" type="email" class="form-control @error('store_email') is-invalid @enderror" name="store_email" value="{{ old('store_email') }}" required autocomplete="store_email">
                               @else
                                 <input id="store_email" type="email" class="form-control @error('store_email') is-invalid @enderror" name="store_email" value="{{ $storeInfo->store_email }}" required autocomplete="store_email">
                               @endif
                                @error('store_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_phone" class="col-md-4 col-form-label text-md-right">{{ __('Store Phone *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                                <input id="store_phone" type="number" class="form-control @error('store_phone') is-invalid @enderror" name="store_phone" value="{{ old('store_phone') }}" required autocomplete="store_phone" autofocus>                         
                              @else
                                  <input id="store_phone" type="number" class="form-control @error('store_phone') is-invalid @enderror" name="store_phone" value="{{ $storeInfo->store_phone }}" required autocomplete="store_phone" autofocus>                         
                              @endif                           
                                @error('store_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  
                        
                        <div class="form-group row">
                            <label for="store_address" class="col-md-4 col-form-label text-md-right">{{ __('Store Address *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                                <input id="store_address" type="text" class="form-control @error('store_address') is-invalid @enderror" name="store_address" value="{{ old('store_address') }}" required autocomplete="store_address" autofocus>                         
                              @else
                                <input id="store_address" type="text" class="form-control @error('store_address') is-invalid @enderror" name="store_address" value="{{ $storeInfo->store_address }}" required autocomplete="store_address" autofocus>                         
                              @endif                              
                                @error('store_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="store_city" class="col-md-4 col-form-label text-md-right">{{ __('Store City *') }}</label>

                            <div class="col-md-6">
                             @if($errors->any())
                               <input id="store_city" type="text" class="form-control @error('store_city') is-invalid @enderror" name="store_city" value="{{ old('store_city') }}" required autocomplete="store_city" autofocus>                         
                             @else
                               <input id="store_city" type="text" class="form-control @error('store_city') is-invalid @enderror" name="store_city" value="{{ $storeInfo->store_city }}" required autocomplete="store_city" autofocus>                         
                             @endif  
                                @error('store_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="store_country" class="col-md-4 col-form-label text-md-right">{{ __('Store Country *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                                 <select name="store_country" value="{{ old('store_country') }}" class="form-control @error('store_country') is-invalid @enderror">
                                   <option value="USA">USA</option>
                                 </select>
                              @else
                                 <select name="store_country" value="{{ $storeInfo->store_country }}" class="form-control @error('store_country') is-invalid @enderror">
                                   <option value="USA">USA</option>
                                 </select>
                              @endif                                   
                                @error('store_country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
 
                        <div class="form-group row">
                            <label for="store_state" class="col-md-4 col-form-label text-md-right">{{ __('Store State *') }}</label>

                            <div class="col-md-6">
                             @if($errors->any())
                               <input id="store_state" type="text" class="form-control @error('store_state') is-invalid @enderror" name="store_state" value="{{ old('store_state') }}" required autocomplete="store_state" autofocus>                         
                             @else
                               <input id="store_state" type="text" class="form-control @error('store_state') is-invalid @enderror" name="store_state" value="{{ $storeInfo->store_state }}" required autocomplete="store_state" autofocus>                         
                             @endif                         
                                @error('store_state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="store_zip" class="col-md-4 col-form-label text-md-right">{{ __('Store Zip Code *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                               <input id="store_zip" type="text" class="form-control @error('store_zip') is-invalid @enderror" name="store_zip" value="{{ old('store_zip') }}" required autocomplete="store_zip" autofocus>                         
                              @else
                               <input id="store_zip" type="text" class="form-control @error('store_zip') is-invalid @enderror" name="store_zip" value="{{ $storeInfo->store_zip }}" required autocomplete="store_zip" autofocus>                         
                              @endif                             
                                @error('store_zip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_picture" class="col-md-4 col-form-label text-md-right">{{ __('Store Image (max s. 2Mb)') }}</label>

                            <div class="col-md-6">
                                <input id="store_picture" type="file" class="form-control @error('store_picture') is-invalid @enderror" name="store_picture" value="{{ old('store_picture') }}" autocomplete="store_picture" autofocus>                                                    
                                @error('store_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="store_lat" class="col-md-4 col-form-label text-md-right">{{ __('Store Latitude *') }}</label>

                            <div class="col-md-6">
                             @if($errors->any())
                               <input id="store_lat" type="text" class="form-control @error('store_lat') is-invalid @enderror" name="store_lat" value="{{ old('store_lat') }}" required autocomplete="store_lat" autofocus>                         
                             @else
                                <input id="store_lat" type="text" class="form-control @error('store_lat') is-invalid @enderror" name="store_lat" value="{{ $storeInfo->store_lat }}" required autocomplete="store_lat" autofocus>                         
                             @endif                           
                                @error('store_lat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
 
                        <div class="form-group row">
                            <label for="store_lon" class="col-md-4 col-form-label text-md-right">{{ __('Store Longitude *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                                <input id="store_lon" type="text" class="form-control @error('store_lon') is-invalid @enderror" name="store_lon" value="{{ old('store_lon') }}" required autocomplete="store_lon" autofocus>                         
                              @else
                                <input id="store_lon" type="text" class="form-control @error('store_lon') is-invalid @enderror" name="store_lon" value="{{ $storeInfo->store_lon }}" required autocomplete="store_lon" autofocus>                         
                              @endif
                                @error('store_lon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                       

                        <div class="form-group row">
                            <label for="store_twitter" class="col-md-4 col-form-label text-md-right">{{ __('Twitter') }}</label>

                            <div class="col-md-6">
                             @if($errors->any())
                               <input id="store_twitter" type="text" class="form-control @error('store_twitter') is-invalid @enderror" name="store_twitter" value="{{ old('store_twitter') }}" autocomplete="store_twitter" autofocus>                         
                             @else
                               @if(isset($storeInfo->social_links))
                                 <input id="store_twitter" type="text" class="form-control @error('store_twitter') is-invalid @enderror" name="store_twitter" value="{{ $storeInfo->social_links->getOriginal('twitter') }}" autocomplete="store_twitter" autofocus>                              
                               @else
                                 <input id="store_twitter" type="text" class="form-control @error('store_twitter') is-invalid @enderror" name="store_twitter" value="" autocomplete="store_twitter" autofocus>                              
                               @endif
                             @endif                         
                                @error('store_twitter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="store_instagram" class="col-md-4 col-form-label text-md-right">{{ __('Instagram') }}</label>

                            <div class="col-md-6">
                             @if($errors->any())
                               <input id="store_instagram" type="text" class="form-control @error('store_instagram') is-invalid @enderror" name="store_instagram" value="{{ old('store_instagram') }}" autocomplete="store_instagram" autofocus>                         
                             @else
                               @if(isset($storeInfo->social_links))
                                  <input id="store_instagram" type="text" class="form-control @error('store_instagram') is-invalid @enderror" name="store_instagram" value="{{ $storeInfo->social_links->getOriginal('instagram') }}" autocomplete="store_instagram" autofocus>                              
                               @else
                                 <input id="store_instagram" type="text" class="form-control @error('store_instagram') is-invalid @enderror" name="store_instagram" value="" autocomplete="store_instagram" autofocus>                               
                               @endif
                             @endif                         
                                @error('store_instagram')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_facebook" class="col-md-4 col-form-label text-md-right">{{ __('Facebook') }}</label>

                            <div class="col-md-6">
                             @if($errors->any())
                               <input id="store_facebook" type="text" class="form-control @error('store_facebook') is-invalid @enderror" name="store_facebook" value="{{ old('store_facebook') }}" autocomplete="store_facebook" autofocus>                         
                             @else
                               @if(isset($storeInfo->social_links))
                                  <input id="store_facebook" type="text" class="form-control @error('store_facebook') is-invalid @enderror" name="store_facebook" value="{{ $storeInfo->social_links->getOriginal('facebook') }}" autocomplete="store_facebook" autofocus>                                
                               @else
                                  <input id="store_facebook" type="text" class="form-control @error('store_facebook') is-invalid @enderror" name="store_facebook" value="" autocomplete="store_facebook" autofocus>         
                               @endif
                             @endif                         
                                @error('store_facebook')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time_zone" class="col-md-4 col-form-label text-md-right">{{ __('Time Zone') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                                 <select name="time_zone" value="{{ old('time_zone') }}" class="form-control @error('time_zone') is-invalid @enderror">
                                   <option value="America/New_york">America/New_york</option>
                                 </select>
                              @else
                                 <select name="time_zone" value="" class="form-control @error('time_zone') is-invalid @enderror">
                                   <option value="America/New_york">America/New_york</option>
                                 </select>
                              @endif                                   
                                @error('time_zone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        
                        <div class="form-group row">
                            <label for="monday" class="col-md-4 col-form-label text-md-right">{{ __('Time Shedule') }}</label>

                            <div class="col-md-6">
							    <fieldset id="monday">
                                <legend>Monday</legend>
                                  <label for="monday_opened">Opened</label>
                                   <input name="monday_work" class="monday_work" type="radio" value="1" checked/>
                                  <label for="monday_closed">Closed</label>
                                   <input name="monday_work" class="monday_work" type="radio" value="0"/>
                                </fieldset>
                               <div class="monday_work_shedule">
                                <b>from:</b>
                                <div class='input-group date' id='monday_from'>
                                 @if($errors->any())
                                   <input type='text' class="form-control" name="monday_from" value="{{ old('monday_from') }}"/>
                                 @else
                                   @if(isset($storeInfo->time_shedule[0]->opened_at))
                                     <input type='text' class="form-control" name="monday_from" value="{{ $storeInfo->time_shedule[0]->opened_at }}"/>
                                   @else
                                     <input type='text' class="form-control" name="monday_from" value=""/>
                                   @endif   
                                 @endif 
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                                <b>to:</b>  
                                <div class='input-group date' id='monday_to'>
                                 @if($errors->any())
                                   <input type='text' class="form-control" name="monday_to" value="{{ old('monday_to') }}"/>
                                 @else
                                   @if(isset($storeInfo->time_shedule[0]->closed_at))  
                                     <input type='text' class="form-control" name="monday_to" value="{{ $storeInfo->time_shedule[0]->closed_at }}"/>
                                   @else
                                     <input type='text' class="form-control" name="monday_to" value=""/> 
                                   @endif   
                                 @endif   
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>  
                               </div>                                                     
                             </div>
                            </div>
                            <div class="form-group row">
                            <label for="tuesday" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
                            
                             <div class="col-md-6">
							    <fieldset id="tuesday">
                                <legend>Tuesday</legend>
                                  <label for="tuesday_opened">Opened</label>
                                   <input name="tuesday_work" class="tuesday_work" type="radio" value="1" checked/>
                                  <label for="tuesday_closed">Closed</label>
                                   <input name="tuesday_work" class="tuesday_work" type="radio" value="0"/>
                                </fieldset>
                               <div class="tuesday_work_shedule">
                                <b>from:</b>
                                <div class='input-group date' id='tuesday_from'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="tuesday_from" value="{{ old('tuesday_from') }}"/>
                                @else  
                                  @if(isset($storeInfo->time_shedule[1]->opened_at))
                                    <input type='text' class="form-control" name="tuesday_from" value="{{ $storeInfo->time_shedule[1]->opened_at }}"/>
                                  @else
                                    <input type='text' class="form-control" name="tuesday_from" value=""/> 
                                  @endif   
                                @endif   
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                                <b>to:</b>  
                                <div class='input-group date' id='tuesday_to'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="tuesday_to" value="{{ old('tuesday_to') }}"/>
                                @else
                                  @if(isset($storeInfo->time_shedule[1]->closed_at))
                                     <input type='text' class="form-control" name="tuesday_to" value="{{ $storeInfo->time_shedule[1]->closed_at }}"/>  
                                  @else
                                     <input type='text' class="form-control" name="tuesday_to" value=""/>   
                                  @endif   
                                @endif    
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>  
                               </div>                                                     
                            </div>                                                      
                         </div>
                            <div class="form-group row">
                            <label for="wednesday" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
                            
                             <div class="col-md-6">
							    <fieldset id="wednesday">
                                <legend>Wednesday</legend>
                                  <label for="wednesday_opened">Opened</label>
                                   <input name="wednesday_work" class="wednesday_work" type="radio" value="1" checked/>
                                  <label for="tuesday_closed">Closed</label>
                                   <input name="wednesday_work" class="wednesday_work" type="radio" value="0"/>
                                </fieldset>
                               <div class="wednesday_work_shedule">
                                <b>from:</b>
                                <div class='input-group date' id='wednesday_from'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="wednesday_from" value="{{ old('wednesday_from') }}"/>
                                @else
                                  @if(isset($storeInfo->time_shedule[2]->opened_at))
                                     <input type='text' class="form-control" name="wednesday_from" value="{{ $storeInfo->time_shedule[2]->opened_at }}"/> 
                                  @else
                                     <input type='text' class="form-control" name="wednesday_from" value=""/>
                                  @endif   
                                @endif        
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                                <b>to:</b>  
                                <div class='input-group date' id='wednesday_to'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="wednesday_to" value="{{ old('wednesday_to') }}" />
                                @else
                                  @if(isset($storeInfo->time_shedule[2]->closed_at))
                                    <input type='text' class="form-control" name="wednesday_to" value="{{ $storeInfo->time_shedule[2]->closed_at }}" /> 
                                  @else
                                    <input type='text' class="form-control" name="wednesday_to" value="" /> 
                                  @endif   
                                @endif   
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>  
                               </div>                                                     
                            </div>                                                      
                         </div>     
                           <div class="form-group row">
                            <label for="thursday" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
                            
                             <div class="col-md-6">
							    <fieldset id="thursday">
                                <legend>Thursday</legend>
                                  <label for="thursday_opened">Opened</label>
                                   <input name="thursday_work" class="thursday_work" type="radio" value="1" checked/>
                                  <label for="thursday_closed">Closed</label>
                                   <input name="thursday_work" class="thursday_work" type="radio" value="0"/>
                                </fieldset>
                               <div class="thursday_work_shedule">
                                <b>from:</b>
                                <div class='input-group date' id='thursday_from'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="thursday_from" value="{{ old('thursday_from') }}"/>
                                @else
                                  @if(isset($storeInfo->time_shedule[3]->opened_at))  
                                    <input type='text' class="form-control" name="thursday_from" value="{{ $storeInfo->time_shedule[3]->opened_at }}"/>
                                  @else
                                    <input type='text' class="form-control" name="thursday_from" value=""/>
                                  @endif   
                                @endif       
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                                <b>to:</b>  
                                <div class='input-group date' id='thursday_to'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="thursday_to" value="{{ old('thursday_to') }}"/>
                                @else
                                  @if(isset($storeInfo->time_shedule[3]->closed_at))
                                     <input type='text' class="form-control" name="thursday_to" value="{{ $storeInfo->time_shedule[3]->closed_at }}"/> 
                                  @else
                                     <input type='text' class="form-control" name="thursday_to" value=""/>
                                  @endif   
                                @endif 
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>  
                               </div>                                                     
                            </div>                                                      
                         </div>   
                           <div class="form-group row">
                            <label for="friday" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
                            
                             <div class="col-md-6">
							    <fieldset id="friday">
                                <legend>Friday</legend>
                                  <label for="friday_opened">Opened</label>
                                   <input name="friday_work" class="friday_work" type="radio" value="1" checked/>
                                  <label for="friday_closed">Closed</label>
                                   <input name="friday_work" class="friday_work" type="radio" value="0"/>
                                </fieldset>
                               <div class="friday_work_shedule">
                                <b>from:</b>
                                <div class='input-group date' id='friday_from'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="friday_from" value="{{ old('friday_from') }}"/>
                                @else
                                  @if(isset($storeInfo->time_shedule[4]->opened_at))
                                    <input type='text' class="form-control" name="friday_from" value="{{ $storeInfo->time_shedule[4]->opened_at }}"/>
                                  @else
                                    <input type='text' class="form-control" name="friday_from" value=""/>
                                  @endif   
                                @endif     
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                                <b>to:</b>  
                                <div class='input-group date' id='friday_to'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="friday_to" value="{{ old('friday_to') }}"/>
                                @else
                                  @if(isset($storeInfo->time_shedule[4]->closed_at))
                                    <input type='text' class="form-control" name="friday_to" value="{{ $storeInfo->time_shedule[4]->closed_at }}"/> 
                                  @else
                                     <input type='text' class="form-control" name="friday_to" value=""/>
                                  @endif   
                                @endif      
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>  
                               </div>                                                     
                            </div>                                                      
                         </div>       
                           <div class="form-group row">
                            <label for="saturday" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
                            
                             <div class="col-md-6">
							    <fieldset id="saturday">
                                <legend>Saturday</legend>
                                  <label for="saturday_opened">Opened</label>
                                   <input name="saturday_work" class="saturday_work" type="radio" value="1" checked/>
                                  <label for="saturday_closed">Closed</label>
                                   <input name="saturday_work" class="saturday_work" type="radio" value="0"/>
                                </fieldset>
                               <div class="saturday_work_shedule">
                                <b>from:</b>
                                <div class='input-group date' id='saturday_from'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="saturday_from" value="{{ old('saturday_from') }}"/>
                                @else
                                   @if(isset($storeInfo->time_shedule[5]->opened_at))
                                     <input type='text' class="form-control" name="saturday_from" value="{{ $storeInfo->time_shedule[5]->opened_at }}"/>
                                   @else
                                     <input type='text' class="form-control" name="saturday_from" value=""/> 
                                   @endif   
                                @endif    
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                                <b>to:</b>  
                                <div class='input-group date' id='saturday_to'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="saturday_to" value="{{ old('saturday_to') }}"/>
                                @else
                                  @if(isset($storeInfo->time_shedule[5]->closed_at)) 
                                    <input type='text' class="form-control" name="saturday_to" value="{{ $storeInfo->time_shedule[5]->closed_at }}"/>
                                  @else
                                    <input type='text' class="form-control" name="saturday_to" value=""/>
                                  @endif   
                                @endif     
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>  
                               </div>                                                     
                            </div>                                                      
                         </div>       
                           <div class="form-group row">
                            <label for="sunday" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
                            
                             <div class="col-md-6">
							    <fieldset id="sunday">
                                <legend>Sunday</legend>
                                  <label for="sunday_opened">Opened</label>
                                   <input name="sunday_work" class="sunday_work" type="radio" value="1" checked/>
                                  <label for="sunday_closed">Closed</label>
                                   <input name="sunday_work" class="sunday_work" type="radio" value="0"/>
                                </fieldset>
                               <div class="sunday_work_shedule">
                                <b>from:</b>
                                <div class='input-group date' id='sunday_from'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="sunday_from" value="{{ old('sunday_from') }}"/>
                                @else
                                   @if(isset($storeInfo->time_shedule[6]->opened_at)) 
                                     <input type='text' class="form-control" name="sunday_from" value="{{ $storeInfo->time_shedule[6]->opened_at }}"/> 
                                   @else
                                     <input type='text' class="form-control" name="sunday_from" value=""/>
                                   @endif   
                                @endif   
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>
                                <b>to:</b>  
                                <div class='input-group date' id='sunday_to'>
                                @if($errors->any())
                                  <input type='text' class="form-control" name="sunday_to" value="{{ old('sunday_to') }}"/>
                                @else
                                   @if(isset($storeInfo->time_shedule[6]->closed_at))
                                     <input type='text' class="form-control" name="sunday_to" value="{{ $storeInfo->time_shedule[6]->closed_at }}"/> 
                                   @else
                                     <input type='text' class="form-control" name="sunday_to" value=""/>   
                                   @endif   
                                @endif  
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                   </span>
                                </div>  
                               </div>                                                     
                            </div>                                                      
                         </div>                                                                                                            
                         <script src="{{ asset('js/shedules.js') }}"></script>                                                                                                                                                                   
                        <div class="form-group row">
                            <label for="store_is_activated" class="col-md-4 col-form-label text-md-right">{{ __('Store Active?') }}</label>

                            <div class="col-md-6">
                               <input id="store_is_activated" type="checkbox" class="form-control @error('store_is_activated') is-invalid @enderror" name="store_is_activated" value="true" autocomplete="store_is_activated" autofocus checked>                         

                                @error('store_is_activated')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                          
                                                                                                                                                
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Save') }}
                                </button>                                
                            </div>
                         </div>   <br>
                         <div class="form-group row mb-0">   
                             <div class="col-md-6 offset-md-4">
                               <a href="{{ route('adminStorePanel.show', $id) }}">
                                <button type="button" class="btn btn-secondary btn-block">
                                    {{ __('Cancel') }}
                                </button> 
                               </a>   
                              </div>                                                           
                        </div>
               </form>
    <!-- /.content -->
</div>
@endsection