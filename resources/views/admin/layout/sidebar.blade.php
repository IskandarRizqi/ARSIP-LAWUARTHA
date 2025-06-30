

<section>

    <!-- Left Sidebar -->

    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="{{ Auth::user()->gambar ? asset('storage/' . Auth::user()->gambar) : asset('images/user.png') }}" 
                 width="48" height="48" alt="User" >
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</div>
                <div class="email">{{ Auth::user()->email }}</div>
                {{-- <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="profile"><i class="material-icons">person</i>Profile</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="actionlogout"><i class="material-icons">input</i>Sign Out</a></li>
                    </ul>
                </div> --}}
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">

            {{-- PIMPINAN / ROOT --}}


                @if(Auth::user()->role == 0) <!-- Pimpinan -->
                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="/home">
                        <i class="material-icons">home</i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ Request::is('menuuser') ? 'active' : '' }}">
                    <a href="/menuuser">
                        <i class="material-icons">person</i>
                        <span>Data User</span>
                    </a>
                </li>
              
                <li >
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">list</i>
                        <span>Master</span>
                    </a>

                    <ul class="ml-menu">
                        <li class="{{ Request::is('menukategori') ? 'active' : '' }}">
                            <a href="/menukategori">Kategori</a>
                        </li>

                        <li class="{{ Request::is('mastersubkategori') ? 'active' : '' }}">
                            <a href="/mastersubkategori">Sub Kategori</a>
                        </li>
                       
                        <li class="{{ Request::is('masterlemari') ? 'active' : '' }}">
                            <a href="/masterlemari">Lemari</a>
                        </li>
                        <li class="{{ Request::is('mastertujuan') ? 'active' : '' }}">
                            <a href="/mastertujuan">Tujuan</a>
                        </li>
                          {{-- <li class="{{ Request::is('mastertype') ? 'active' : '' }}">
                            <a href="/mastertype">Type</a>
                        </li> --}}
                    </ul>
                </li>
                

             
            
              
                <li class="{{ Request::is('menuarsip') ? 'active' : '' }}">
                    <a href="/menuarsip">
                        <i class="material-icons">description</i>
                        <span>Data Arsip</span>
                    </a>
                </li>
                
                <li class="{{ Request::is('menuapprove') ? 'active' : '' }}">
                    <a href="/menuapprove">
                        <i class="material-icons">check_circle</i>
                        <span>Approval</span>
                    </a>
                </li>
                <li class="{{ Request::is('loghistoryall') ? 'active' : '' }}">
                    <a href="/loghistoryall">
                        <i class="material-icons">history</i>
                        <span>Log History</span>
                    </a>
                </li>
                <li class="{{ Request::is('menuunduh') ? 'active' : '' }}">    
                    <a href="/menuunduh">
                        <i class="material-icons">download</i>
                        <span>Riwayat Unduh</span>
                    </a>
                </li>
                 @endif


             {{-- PETUGAS / ADMIN --}}


                 @if(Auth::user()->role == 1) <!-- petugas -->
                 <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="/home">
                        <i class="material-icons">home</i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ Request::is('menuuser') ? 'active' : '' }}">
                    <a href="/menuuser">
                        <i class="material-icons">person</i>
                        <span>Data User</span>
                    </a>
                </li>
              
                <li >
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">list</i>
                        <span>Master</span>
                    </a>

                    <ul class="ml-menu">
                        <li class="{{ Request::is('menukategori') ? 'active' : '' }}">
                            <a href="/menukategori">Kategori</a>
                        </li>

                        <li class="{{ Request::is('mastersubkategori') ? 'active' : '' }}">
                            <a href="/mastersubkategori">Sub Kategori</a>
                        </li>
                       
                        <li class="{{ Request::is('masterlemari') ? 'active' : '' }}">
                            <a href="/masterlemari">Lemari</a>
                        </li>
                        <li class="{{ Request::is('mastertujuan') ? 'active' : '' }}">
                            <a href="/mastertujuan">Tujuan</a>
                        </li>
                          {{-- <li class="{{ Request::is('mastertype') ? 'active' : '' }}">
                            <a href="/mastertype">Type</a>
                        </li> --}}
                    </ul>
                </li>

             
            
              
                <li class="{{ Request::is('menuarsip') ? 'active' : '' }}">
                    <a href="/menuarsip">
                        <i class="material-icons">description</i>
                        <span>Data Arsip</span>
                    </a>
                </li>
                <li class="{{ Request::is('menuapprove') ? 'active' : '' }}">
                    <a href="/menuapprove">
                        <i class="material-icons">check_circle</i>
                        <span>Approval</span>
                    </a>
                </li>
                 
               
                  @endif


            {{-- USER --}}
                  
                 @if(Auth::user()->role == 2) <!-- user -->
                 <li class="{{ Request::is('home') ? 'active' : '' }}">
                     <a href="/home">
                         <i class="material-icons">home</i>
                         <span>Dashboard</span>
                     </a>
                 </li>

                
                 <li class="{{ Request::is('arsipkaryawan') ? 'active' : '' }}">
                    <a href="/arsipkaryawan">
                        <i class="material-icons">description</i>
                        <span>Data Arsip</span>
                    </a>
                </li>

                <li class="{{ Request::is('logpengajuan') ? 'active' : '' }}">
                    <a href="/logpengajuan">
                        <i class="material-icons">assignment</i>

                        <span>Log Pengajuan</span>
                    </a>
                </li>
                <li class="{{ Request::is('loghistory') ? 'active' : '' }}">
                    <a href="/loghistory">
                        <i class="material-icons">history</i>
                        <span>Log History</span>
                    </a>
                </li>

                 
 
               
                 
               
                  @endif
              
               
               
               
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        {{-- <div class="legal">
            <div class="copyright">
                &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0.5
            </div>
        </div> --}}
        <!-- #Footer -->
    </aside>


 
</section>



