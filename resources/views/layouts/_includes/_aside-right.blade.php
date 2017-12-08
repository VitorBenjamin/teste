<section>
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#skins" data-toggle="tab">CADASTROS</a></li>
            <li role="presentation"><a href="#settings" data-toggle="tab">RELATÓRIOS</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                <ul class="demo-choose-skin menuDireito">
                    <li><a href="{{ route('user.getAll') }}"><i class="material-icons">sd_storage</i><span>Cadastrar. Cliente</span></a></li>
                    <li><a href="{{ route('user.getAll') }}"><i class="material-icons">sd_storage</i><span>Cadastrar. Unidade</span></a></li>
                    <li><a href="{{ route('user.getAll') }}"><i class="material-icons">sd_storage</i><span>Cadastrar. Processo</span></a></li>
                </ul>

            </div>
            <div role="tabpanel" class="tab-pane fade" id="settings">
                <div class="demo-settings">
                    <p>RELATÓRIOS ESPECIFICOS</p>
                    <!-- <ul class="setting-list">
                        <li>
                            <span>Report Panel Usage</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Email Redirect</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>SYSTEM SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Notifications</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Auto Updates</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>ACCOUNT SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Offline</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Location Permission</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul> -->
                </div>
            </div>
        </div>
    </aside>
    <!-- #END# Right Sidebar -->
</section>