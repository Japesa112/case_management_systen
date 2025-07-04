@extends('layouts.default', ['appContentFullHeight' => true, 'appHeaderInverse' => true, 'appSidebarMinified' => true, 'appContentClass' => 'd-flex flex-column'])

@section('title', 'File Manager')

@push('scripts')
	<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
	<script src="/assets/js/demo/file-manager.demo.js"></script>
@endpush

@section('content')
	<div>
		<!-- BEGIN breadcrumb -->
		<ol class="breadcrumb float-xl-end">
			<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Extra</a></li>
			<li class="breadcrumb-item active">File Manager</li>
		</ol>
		<!-- END breadcrumb -->
		<!-- BEGIN page-header -->
		<h1 class="page-header">File Manager <small>header small text goes here...</small></h1>
		<!-- END page-header -->
	</div>

	<div class="panel panel-inverse flex-1 m-0 d-flex flex-column overflow-hidden">
		<div class="panel-heading">
			<h4 class="panel-title">File Manager</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body p-0 flex-1 overflow-hidden">
			<div class="file-manager h-100" id="fileManager">
				<div class="file-manager-toolbar">
					 <button type="button" class="btn shadow-none text-body border-0"><i class="fa fa-lg me-1 fa-plus"></i> File</button>
					 <button type="button" class="btn shadow-none text-body border-0"><i class="fa fa-lg me-1 fa-plus"></i> Folder</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-copy"></i> Copy</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-move"></i> Move</button>
					 <button type="button" class="btn shadow-none text-body border-0"><i class="fa fa-lg me-1 fa-upload"></i> Upload</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-download"></i> Download</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-xmark"></i> Delete</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-rotate-left"></i> Restore</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-file"></i> Rename</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-pen"></i> Edit</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-pen-to-square"></i> HTML Editor</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-key"></i> Permissions</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-file"></i> View</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-lock-open"></i> Extract</button>
					 <button type="button" class="btn shadow-none text-body text-opacity-50 border-0" disabled><i class="fa fa-lg me-1 fa-file-zipper"></i> Compress</button>
				</div>
				<div class="file-manager-container">
					<div class="file-manager-sidebar">
						<div class="file-manager-sidebar-mobile-toggler">
							<button type="button" class="btn" data-toggle-class="file-manager-sidebar-mobile-toggled" data-target="#fileManager"><i class="far fa-lg fa-folder"></i></button>
						</div>
						<div class="file-manager-sidebar-content">
							<div data-scrollbar="true" data-height="100%" class="p-3">
								<input type="text" class="form-control form-control-sm mb-3" placeholder="Seach file..." />
								<div class="file-tree mb-3">
									<div class="file-node has-sub expand selected">
										<a href="javascript:;" class="file-link">
											<span class="file-arrow"></span>
											<span class="file-info">
												<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
												<span class="file-text">public_html</span>
											</span>
										</a>
										<div class="file-tree">
											<div class="file-node has-sub">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
														<span class="file-text">services</span>
													</span>
												</a>
												<div class="file-tree">
													<div class="file-node has-sub">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
																<span class="file-text">app_development</span>
															</span>
														</a>
														<div class="file-tree">
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">index.html</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">android_app.html</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">ios_app.html</span>
																	</span>
																</a>
															</div>
														</div>
													</div>
													<div class="file-node has-sub">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
																<span class="file-text">digital_marketing</span>
															</span>
														</a>
														<div class="file-tree">
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">index.html</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">social_media.html</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">seo.html</span>
																	</span>
																</a>
															</div>
														</div>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">index.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">web_design.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">seo_services.html</span>
															</span>
														</a>
													</div>
												</div>
											</div>
											<div class="file-node has-sub">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
														<span class="file-text">portfolio</span>
													</span>
												</a>
												<div class="file-tree">
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">index.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">project_1.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">project_2.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">project_3.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">project_4.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">project_5.html</span>
															</span>
														</a>
													</div>
												</div>
											</div>
											<div class="file-node has-sub">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
														<span class="file-text">blog</span>
													</span>
												</a>
												<div class="file-tree">
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">index.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">post_1.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">post_2.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">post_3.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">post_4.html</span>
															</span>
														</a>
													</div>
													<div class="file-node">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
																<span class="file-text">post_5.html</span>
															</span>
														</a>
													</div>
												</div>
											</div>
											<div class="file-node has-sub">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
														<span class="file-text">assets</span>
													</span>
												</a>
												<div class="file-tree">
													<div class="file-node has-sub">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
																<span class="file-text">css</span>
															</span>
														</a>
														<div class="file-tree">
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">styles.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">main.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">responsive.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">typography.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">colors.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">layout.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">animations.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">forms.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">buttons.css</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">grids.css</span>
																	</span>
																</a>
															</div>
														</div>
													</div>
													<div class="file-node has-sub">
														<a href="javascript:;" class="file-link">
															<span class="file-arrow"></span>
															<span class="file-info">
																<span class="file-icon"><i class="fa fa-folder fa-lg text-warning"></i></span>
																<span class="file-text">js</span>
															</span>
														</a>
														<div class="file-tree">
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">main.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">script.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">sliders.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">gallery.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">form-validation.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">animations.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">navigation.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">modal.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">tabs.js</span>
																	</span>
																</a>
															</div>
															<div class="file-node">
																<a href="javascript:;" class="file-link">
																	<span class="file-arrow"></span>
																	<span class="file-info">
																		<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
																		<span class="file-text">accordion.js</span>
																	</span>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">index.html</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">home.html</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">about.html</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">contact.html</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">testimonials.html</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">faq.html</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">pricing.html</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-code fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">404.shtml</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="fa fa-file-text fa-lg text-body text-opacity-50"></i></span>
														<span class="file-text">.htaccess</span>
													</span>
												</a>
											</div>
											<div class="file-node">
												<a href="javascript:;" class="file-link">
													<span class="file-arrow"></span>
													<span class="file-info">
														<span class="file-icon"><i class="far fa-file-image fa-lg text-success"></i></span>
														<span class="file-text">favicon.ico</span>
													</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="file-manager-sidebar-footer">
							<div class="d-flex align-items-center">
								<div class="mx-n1">
									<iconify-icon class="fa-3x" icon="solar:ssd-square-bold-duotone"></iconify-icon>
								</div>
								<div class="flex-1 ps-3 small">
									<div class="fw-bold">SSD Storage:</div>
									<div class="progress h-5px my-1">
										<div class="progress-bar progress-bar-striped bg-inverse" style="width: 80%"></div>
									</div>
									<div class="fw-bold text-body text-opacity-75">
										<b class="text-body">127.7GB</b> free of <b class="text-body">256GB</b>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="file-manager-content d-flex flex-column">
						<div class="mb-0 d-flex text-nowrap p-3 border-bottom">
							<button type="button" class="btn btn-sm btn-white me-2 px-2"><i class="fa fa-fw fa-home"></i></button>
							<button type="button" class="btn btn-sm btn-white me-2" disabled><i class="fa fa-fw fa-arrow-turn-up ms-n1"></i>  Up One Level</button>
				
							<div class="btn-group me-2">
								<button type="button" class="btn btn-sm btn-white" disabled><i class="fa me-1 fa-arrow-left"></i> Back</button>
								<button type="button" class="btn btn-sm btn-white text-opacity-50" disabled><i class="fa me-1 fa-arrow-right"></i> Forward</button>
							</div>
							<button type="button" class="btn btn-sm btn-white me-2 px-2"><i class="fa fa-fw fa-arrows-rotate"></i></button>
				
							<div class="btn-group me-2">
								<button type="button" class="btn btn-sm btn-white"><i class="fa fa-fw fa-check ms-n1"></i> Select All</button>
								<button type="button" class="btn btn-sm btn-white"><i class="far fa-fw fa-square ms-n1"></i> Unselect All</button>
							</div>
						</div>
						<div class="flex-1 overflow-hidden">
							<div data-scrollbar="true" data-skip-mobile="true" data-height="100%" class="p-0">
								<table class="table table-striped table-borderless table-sm m-0 text-nowrap">
									<thead>
										<tr class="border-bottom">
											<th class="w-10px ps-10px"></th>
											<th class="px-10px">Name</th>
											<th class="px-10px w-100px">Size</th>
											<th class="px-10px w-200px">Last Modified</th>
											<th class="px-10px w-200px">Type</th>
											<th class="px-10px w-100px">Permission</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">services</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:35PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">portfolio</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:36PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">blog</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:04PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">assets</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:14PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">php</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:36PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">docs</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:36PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">archives</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:36PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">video</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:36PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">audio</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:36PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-folder text-warning fa-lg"></i></td>
											<td class="px-10px border-0">docs</td>
											<td class="px-10px">4 KB</td>
											<td class="px-10px">Jun 11, 2023, 10:36PM</td>
											<td class="px-10px">http:/unix-directory</td>
											<td class="px-10px border-0">0755</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-code text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">index.html</td>
											<td class="px-10px">39.5 KB</td>
											<td class="px-10px">July 05, 2023, 10:35PM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-code text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">home.html</td>
											<td class="px-10px">129.1 KB</td>
											<td class="px-10px">July 06, 2023, 1:00PM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-code text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">about.html</td>
											<td class="px-10px">24 KB</td>
											<td class="px-10px">July 01, 2023, 6:59AM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-code text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">contact.html</td>
											<td class="px-10px">39.5 KB</td>
											<td class="px-10px">July 05, 2023, 10:35PM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-code text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">testimonials.html</td>
											<td class="px-10px">11 KB</td>
											<td class="px-10px">July 05, 2023, 10:35PM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-code text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">faq.html</td>
											<td class="px-10px">12 KB</td>
											<td class="px-10px">July 05, 2023, 1.59PM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-code text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">pricing.html</td>
											<td class="px-10px">128 KB</td>
											<td class="px-10px">July 05, 2023, 12.49PM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-code text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">404.shtml</td>
											<td class="px-10px">251 bytes</td>
											<td class="px-10px">July 10, 2023, 10.35AM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="fa fa-file-text text-body text-opacity-50 fa-lg"></i></td>
											<td class="px-10px border-0">.htaccess</td>
											<td class="px-10px">128 KB</td>
											<td class="px-10px">August 05, 2023, 12.49PM</td>
											<td class="px-10px">text/html</td>
											<td class="px-10px border-0">0644</td>
										</tr>
										<tr>
											<td class="ps-10px border-0 text-center"><i class="far fa-file-image text-teal fa-lg"></i></td>
											<td class="px-10px border-0">favicon.ico</td>
											<td class="px-10px">2 KB</td>
											<td class="px-10px">July 05, 2023, 7.39AM</td>
											<td class="px-10px">image/x-generic</td>
											<td class="px-10px border-0">0644</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection