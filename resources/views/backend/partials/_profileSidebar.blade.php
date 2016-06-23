<div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
            <div class="panel panel-default" id="dd-list">
              <div class="panel-thumbnail"><img src={{ asset('img/sample.png') }} class="img-responsive"></div>
              <div class="panel-body">
                <p class="lead">{{ $user->getMembership->getName() }}</p>
                <ul class="list-unstyled">
                    
                    <!-- postal address info -->
                    @forelse ($user->addresses as $address)
                      <li>
                      <span class="glyphicon glyphicon-map-marker"></span><span class="header">{{ $address->type->type }}</span>
                      <address>
                        {{ $address->address_line_1 }}<br>
                        {{ $address->city }}, {{ $address->state->name }}, {{ $address->pincode }}, {{ $address->country->name }}
                      </address>
                      </li>
                    @empty
                      {{-- <li> --}}
                      {{-- empty expr --}}
                      {{-- </li> --}}
                    @endforelse

                    <!-- phone numbers -->
                    <li>
                      <span class="glyphicon glyphicon-earphone"></span>
                        @foreach ($user->phones as $phone)
                              <address>
                                 @if ( !is_null($phone->landline) && $phone->landline!= '')
                                    <abbr title="Landline">P:</abbr> ({{ $phone->std_code }}) {{ $phone->landline }}<br/>
                                 @endif
                                 @if ( !is_null($phone->mobile) && $phone->mobile!= '')
                                    <abbr title="Mobile">P:</abbr> +({{ $phone->country_code }}) {{ $phone->mobile}}<br/>
                                 @endif
                              </address>
                        @endforeach
                    </li>
                    <!-- emails --> 
                    <li>
                        <span class="glyphicon glyphicon-envelope"></span><span class="header">Primary Email [Login Email-ID]</span>
                          {{ $user->email }}
                        @if ( !is_null($user->email_extra) && $user->email_extra!='')
                           <span class="header">Secondary Email</span>
                           {{ $user->email_extra }}
                        @endif
                    </li>

                </ul>
              </div>
            </div>
          </div> <!-- div card-->
          
        @if ($user->membership->id == 1)
          <div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
            <div class="panel panel-default" id="dd-list">
              <div class="panel-heading">
                <h6>
                  Institution Details
                </h6>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled">
                    
                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Institution Category</span>
                      @if ($user->getMembership->membershipType->id == 1)
                        {{ $user->getMembership->membershipType->type }}  - {{ $user->getMembership->subType->InstitutionType->name  }}
                      @else 
                        {{ $user->getMembership->membershipType->type }}
                        {{-- expr --}}
                      @endif
                    
                  </li>

                  @if ($user->getMembership->membershipType->type == 'academic')
                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Is a Student Branch</span>
                    @if ($user->getMembership->subType->is_student_branch == 1)
                        yes
                      @else 
                        No
                        {{-- expr --}}
                    @endif
                  </li>
                  @endif

                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Email (Login ID)</span>
                       {{ $user->email }}
                  </li>

                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Chapter</span>
                      {{ $user->chapter->name }}
                  </li>
                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Region</span>
                       {{ $user->chapter->state->region->name }}
                  </li>

                </ul>
              </div>
            </div>
          </div> <!-- div card-->

          <div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
            <div class="panel panel-default" id="dd-list">
              <div class="panel-heading">
                <h6>
                  Details of Head of the Institution
                </h6>
              </div>
              <div class="panel-body">
                <p class="lead">{{$user->getMembership->salutation->name}} {{ $user->getMembership->head_name }}</p>
                <ul class="list-unstyled">
                    
                  <li>
                    <span class="glyphicon glyphicon-briefcase"></span><span class="header">Designation</span>
                       {{ $user->getMembership->head_designation }}
                 </li>
                 <li>
                   <span class="glyphicon glyphicon-envelope"></span><span class="header">Email</span>
                    
                       {{ $user->getMembership->email }}
                 </li>


                 <li>
                   <span class="glyphicon glyphicon-envelope"></span>
                          <abbr title="Mobile">M: </abbr> +( {{ $user->getMembership->country_code }} ) {{ $user->getMembership->mobile }}
                    </li>

                </ul>
              </div>
            </div>
          </div> <!-- div card-->
        @elseif ($user->membership->id == 2)
          <div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
            <div class="panel panel-default" id="dd-list">
              <div class="panel-heading">
                <h6>
                  Individual Details
                </h6>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled">
                    
                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Individual Category</span>
                        {{ $user->getMembership->membershipType->type }}
                  </li>

                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Email (Login ID)</span>
                       {{ $user->email }}
                  </li>

                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Chapter</span>
                      {{ $user->chapter->name }}
                  </li>
                  <li>
                    <span class="glyphicon glyphicon-tag"></span><span class="header">Region</span>
                       {{ $user->chapter->state->region->name }}
                  </li>

                </ul>
              </div>
            </div>
          </div> <!-- div card-->
          @if ($user->getMembership->membershipType->id == 3) <!-- student -->
            <div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
              <div class="panel panel-default" id="dd-list">
                <div class="panel-heading">
                  <h6>
                    Student Details
                  </h6>
                </div>
                <div class="panel-body">
                  
                  <ul class="list-unstyled">
                    <li>
                      <span class="glyphicon glyphicon-envelope"></span><span class="header">College</span>
                          {{ $user->getMembership->subType->college_name }}
                    </li>

                    <li>
                      <span class="glyphicon glyphicon-envelope"></span><span class="header">Course</span>
                          {{ $user->getMembership->subType->course_name }}
                    </li>

                    <li>
                      <span class="glyphicon glyphicon-envelope"></span><span class="header">Course Branch</span>
                          {{ $user->getMembership->subType->course_branch }}
                    </li>

                    <li>
                      <span class="glyphicon glyphicon-envelope"></span><span class="header">Course Duration</span>
                          {{ $user->getMembership->subType->course_duration }}
                    </li>
                    
                    <li>
                      <span class="glyphicon glyphicon-envelope"></span><span class="header">Student Branch</span>
                          {{ $user->getMembership->subType->institution->getname() }}
                    </li>
                    
                  </ul>
                </div>
              </div>
            </div> <!-- div card-->
          @elseif ($user->getMembership->membershipType->id == 4) <!-- professional -->
            <div class="col-md-12 col-sm-12 col-xs-12"> <!-- div card -->
              <div class="panel panel-default" id="dd-list">
                <div class="panel-heading">
                  <h6>
                    Professional Details
                  </h6>
                </div>
                <div class="panel-body">
                  
                  <ul class="list-unstyled">
                    <li>
                      <span class="glyphicon glyphicon-envelope"></span><span class="header">Is Nominee?</span>
                          @if ($user->getMembership->subType->is_nominee == 1)
                            yes
                          @else
                            no
                          @endif
                    </li>
                    @if ( !is_null($user->getMembership->subType->associating_institution_id) )
                      <li>
                        <span class="glyphicon glyphicon-envelope"></span><span class="header">Associating Institution</span>
                            {{ $user->getMembership->subType->institution->getname() }}
                      </li>
                    @endif
                    <li>
                      <span class="glyphicon glyphicon-briefcase"></span><span class="header">Designation</span>
                         {{ $user->getMembership->subType->designation }}
                   </li>
                   <li>
                     <span class="glyphicon glyphicon-envelope"></span><span class="header">Organisation</span>
                      
                         {{ $user->getMembership->subType->organisation }}
                   </li>

                  </ul>
                </div>
              </div>
            </div> <!-- div card-->

          @endif
        @endif