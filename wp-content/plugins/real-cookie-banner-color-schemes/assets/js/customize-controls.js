// Define global variables for later use
var rcbcs_acceptAllIsButton;
var rcbcs_acceptEssentialsIsButton;
var rcbcs_acceptIndividualIsButton;
var rcbcs_saveIsButton;
var rcbcs_secondaryLikePrimary;
var rcbcs_saveLikePrimary;
var rcbcs_customizeBindDone = false;

// Initialization...
if(typeof wp.customize != 'undefined') {
	wp.customize.bind('ready', function() {
		// ...of Button types
		rcbcs_acceptAllIsButton = wp.customize('rcb-banner-decision-accept-all').get() == 'button';
		rcbcs_acceptEssentialsIsButton = wp.customize('rcb-banner-decision-accept-essentials').get() == 'button';
		rcbcs_acceptIndividualIsButton = wp.customize('rcb-banner-decision-accept-individual').get() == 'button';
		rcbcs_saveIsButton = wp.customize('rcb-save-button-type').get() == 'button';

		rcbcs_secondaryLikePrimary = wp.customize('rcb-banner-body-design-btn-accept-essentials-use-accept-all').get() == 1;
		if(rcbcs_secondaryLikePrimary) {
			jQuery("#customize-control-rcbcs-secondary-color").hide();
			jQuery("#customize-control-rcbcs-secondary-color-hover").hide();
			wp.customize('rcb-banner-header-design-border-color').set(wp.customize('rcbcs-primary-color').get());
			wp.customize('rcb-banner-footer-design-border-color').set(wp.customize('rcbcs-primary-color').get());
		} else {
			wp.customize('rcb-banner-header-design-border-color').set(wp.customize('rcbcs-secondary-color').get());
			wp.customize('rcb-banner-footer-design-border-color').set(wp.customize('rcbcs-secondary-color').get());
		}

		rcbcs_saveLikePrimary = wp.customize('rcb-save-button-use-accept-all').get() == 1;
		
		if(!rcbcs_acceptIndividualIsButton) {
			wp.customize('rcb-banner-body-design-btn-accept-individual-font-color').set(wp.customize('rcbcs-link-color').get());
			wp.customize('rcb-banner-body-design-btn-accept-individual-hover-font-color').set(wp.customize('rcbcs-link-color-hover').get());
		}
		rcbcs_customizeBindDone = true;
	})
}

jQuery(document).ready(function($) {
	
	// Initialization...
	if(!rcbcs_customizeBindDone) {
		wp.customize.bind('ready', function() {
			// ...of Button types
			rcbcs_acceptAllIsButton = wp.customize('rcb-banner-decision-accept-all').get() == 'button';
			rcbcs_acceptEssentialsIsButton = wp.customize('rcb-banner-decision-accept-essentials').get() == 'button';
			rcbcs_acceptIndividualIsButton = wp.customize('rcb-banner-decision-accept-individual').get() == 'button';
			rcbcs_saveIsButton = wp.customize('rcb-save-button-type').get() == 'button';
			
			rcbcs_secondaryLikePrimary = wp.customize('rcb-banner-body-design-btn-accept-essentials-use-accept-all').get() == 1;
			if(rcbcs_secondaryLikePrimary) {
				$("#customize-control-rcbcs-secondary-color").hide();
				$("#customize-control-rcbcs-secondary-color-hover").hide();
				wp.customize('rcb-banner-header-design-border-color').set(wp.customize('rcbcs-primary-color').get());
				wp.customize('rcb-banner-footer-design-border-color').set(wp.customize('rcbcs-primary-color').get());
			} else {
				wp.customize('rcb-banner-header-design-border-color').set(wp.customize('rcbcs-secondary-color').get());
				wp.customize('rcb-banner-footer-design-border-color').set(wp.customize('rcbcs-secondary-color').get());
			}

			rcbcs_saveLikePrimary = wp.customize('rcb-save-button-use-accept-all').get() == 1;
			
			if(!rcbcs_acceptIndividualIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-individual-font-color').set(wp.customize('rcbcs-link-color').get());
				wp.customize('rcb-banner-body-design-btn-accept-individual-hover-font-color').set(wp.customize('rcbcs-link-color-hover').get());
			}
		})
	}

	/**
	 *  Catch change of settings in RCB section
	 */
	
	// Accept all
	wp.customize('rcb-banner-decision-accept-all', function(control) {
		control.bind(function(controlValue) {
			if(controlValue == 'button') rcbcs_acceptAllIsButton = true;
			else rcbcs_acceptAllIsButton = false;
			if(rcbcs_acceptAllIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-all-font-color').set(wp.customize('rcbcs-background-color').get());
				wp.customize('rcb-banner-body-design-btn-accept-all-hover-font-color').set(wp.customize('rcbcs-background-color').get());
			} else {
				wp.customize('rcb-banner-body-design-btn-accept-all-font-color').set(wp.customize('rcbcs-primary-color').get());
				wp.customize('rcb-banner-body-design-btn-accept-all-hover-font-color').set(wp.customize('rcbcs-primary-color-hover').get());
			}
		});
	});
	
	// Accept essentials
	wp.customize('rcb-banner-decision-accept-essentials', function(control) {
		control.bind(function(controlValue) {
			if(controlValue == 'button') rcbcs_acceptEssentialsIsButton = true;
			else rcbcs_acceptEssentialsIsButton = false;
			if(rcbcs_acceptEssentialsIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-essentials-font-color').set(wp.customize('rcbcs-primary-font-color').get());
				wp.customize('rcb-banner-body-design-btn-accept-essentials-hover-font-color').set(wp.customize('rcbcs-primary-font-color').get());
			} else {
				wp.customize('rcb-banner-body-design-btn-accept-essentials-font-color').set(wp.customize('rcbcs-link-color').get());
				wp.customize('rcb-banner-body-design-btn-accept-essentials-hover-font-color').set(wp.customize('rcbcs-link-color-hover').get());
			}
		});
	});
	
	// Accept individual
	wp.customize('rcb-banner-decision-accept-individual', function(control) {
		control.bind(function(controlValue) {
			if(controlValue == 'button') rcbcs_acceptIndividualIsButton = true;
			else rcbcs_acceptIndividualIsButton = false;
			if(rcbcs_acceptIndividualIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-individual-font-color').set(wp.customize('rcbcs-primary-font-color').get());
				wp.customize('rcb-banner-body-design-btn-accept-individual-hover-font-color').set(wp.customize('rcbcs-primary-font-color').get());
			} else {
				wp.customize('rcb-banner-body-design-btn-accept-individual-font-color').set(wp.customize('rcbcs-link-color').get());
				wp.customize('rcb-banner-body-design-btn-accept-individual-hover-font-color').set(wp.customize('rcbcs-link-color-hover').get());
			}
		});
	});
	
	// Save button
	wp.customize('rcb-save-button-type', function(control) {
		control.bind(function(controlValue) {
			if(controlValue == 'button') rcbcs_saveIsButton = true;
			else rcbcs_saveIsButton = false;
			if(rcbcs_saveIsButton) {
				wp.customize('rcb-save-button-font-color').set(wp.customize('rcbcs-primary-font-color').get());
				wp.customize('rcb-save-button-hover-font-color').set(wp.customize('rcbcs-primary-font-color').get());
			} else {
				wp.customize('rcb-save-button-font-color').set(wp.customize('rcbcs-link-color').get());
				wp.customize('rcb-save-button-hover-font-color').set(wp.customize('rcbcs-link-color-hover').get());
			}
		});
	});
	
	// Accept essentials like accept all (Secondary like primary)
	// Catch change of RCB setting and modify RCBCS setting
	wp.customize('rcb-banner-body-design-btn-accept-essentials-use-accept-all', function(control) {
		control.bind(function(controlValue) {
			if(controlValue) rcbcs_secondaryLikePrimary = true;
			else rcbcs_secondaryLikePrimary = false;
			if(rcbcs_secondaryLikePrimary) {
				wp.customize('rcbcs-secondary-like-primary').set(true);
				$("#customize-control-rcbcs-secondary-color").hide();
				$("#customize-control-rcbcs-secondary-color-hover").hide();
				wp.customize('rcb-banner-header-design-border-color').set(wp.customize('rcbcs-primary-color').get());
				wp.customize('rcb-banner-footer-design-border-color').set(wp.customize('rcbcs-primary-color').get());
			} else {
				wp.customize('rcbcs-secondary-like-primary').set(false);
				$("#customize-control-rcbcs-secondary-color").show();
				$("#customize-control-rcbcs-secondary-color-hover").show();
				wp.customize('rcb-banner-header-design-border-color').set(wp.customize('rcbcs-secondary-color').get());
				wp.customize('rcb-banner-footer-design-border-color').set(wp.customize('rcbcs-secondary-color').get());
			}
		});
	});
	// Catch change of RCBCS setting and modify RCB setting
	wp.customize('rcbcs-secondary-like-primary', function(control) {
		control.bind(function(controlValue) {
			if(controlValue) rcbcs_secondaryLikePrimary = true;
			else rcbcs_secondaryLikePrimary = false;
			if(rcbcs_secondaryLikePrimary) {
				wp.customize('rcb-banner-body-design-btn-accept-essentials-use-accept-all').set(true);
				$("#customize-control-rcbcs-secondary-color").hide();
				$("#customize-control-rcbcs-secondary-color-hover").hide();
				wp.customize('rcb-banner-header-design-border-color').set(wp.customize('rcbcs-primary-color').get());
				wp.customize('rcb-banner-footer-design-border-color').set(wp.customize('rcbcs-primary-color').get());
			} else {
				wp.customize('rcb-banner-body-design-btn-accept-essentials-use-accept-all').set(false);
				$("#customize-control-rcbcs-secondary-color").show();
				$("#customize-control-rcbcs-secondary-color-hover").show();
				wp.customize('rcb-banner-header-design-border-color').set(wp.customize('rcbcs-secondary-color').get());
				wp.customize('rcb-banner-footer-design-border-color').set(wp.customize('rcbcs-secondary-color').get());
			}
		});
	});

	// Save individual button like accept all (Save like primary)
	// Catch change of RCB setting and modify RCBCS setting
	wp.customize('rcb-save-button-use-accept-all', function(control) {
		control.bind(function(controlValue) {
			if(controlValue) rcbcs_saveLikePrimary = true;
			else rcbcs_saveLikePrimary = false;
			if(rcbcs_saveLikePrimary) {
				wp.customize('rcbcs-save-like-primary').set(true);
			} else {
				wp.customize('rcbcs-save-like-primary').set(false);
			}
		});
	});
	// Catch change of RCBCS setting and modify RCB setting
	wp.customize('rcbcs-save-like-primary', function(control) {
		control.bind(function(controlValue) {
			if(controlValue) rcbcs_saveLikePrimary = true;
			else rcbcs_saveLikePrimary = false;
			if(rcbcs_saveLikePrimary) {
				wp.customize('rcb-save-button-use-accept-all').set(true);
			} else {
				wp.customize('rcb-save-button-use-accept-all').set(false);
			}
		});
	});
	
	/**
	 *  Assign colors
	 */
	
	// Primary color
	wp.customize('rcbcs-primary-color', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-group-checkbox-active-bg').set(controlValue);
			wp.customize('rcb-banner-body-design-btn-accept-all-bg').set(controlValue);
			wp.customize('rcb-banner-body-design-teachings-separator-color').set(controlValue);
			wp.customize('rcb-banner-body-design-dotted-groups-bullet-color').set(controlValue);
			if(!rcbcs_acceptAllIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-all-font-color').set(controlValue);
			}
		});
	});
	
	// Primary color hover
	wp.customize('rcbcs-primary-color-hover', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-group-checkbox-active-border-color').set(controlValue);
			wp.customize('rcb-banner-body-design-btn-accept-all-hover-bg').set(controlValue);
			if(!rcbcs_acceptAllIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-all-hover-font-color').set(controlValue);
			}
		});
	});
	
	// Secondary color
	wp.customize('rcbcs-secondary-color', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-save-button-bg').set(controlValue);
			wp.customize('rcb-banner-body-design-btn-accept-essentials-bg').set(controlValue);
			wp.customize('rcb-banner-body-design-btn-accept-individual-bg').set(controlValue);
			wp.customize('rcb-save-button-bg').set(controlValue);
			wp.customize('rcb-banner-footer-design-border-color').set(controlValue);
			wp.customize('rcb-banner-header-design-border-color').set(controlValue);
		});
	});
	
	// Secondary color hover
	wp.customize('rcbcs-secondary-color-hover', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-save-button-hover-bg').set(controlValue);
			wp.customize('rcb-banner-body-design-btn-accept-essentials-hover-bg').set(controlValue);
			wp.customize('rcb-banner-body-design-btn-accept-individual-hover-bg').set(controlValue);
			wp.customize('rcb-save-button-hover-bg').set(controlValue);
		});
	});

	// Banner background color
	wp.customize('rcbcs-background-color', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-banner-design-bg').set(controlValue);
			wp.customize('rcb-banner-design-border-color').set(controlValue);
			wp.customize('rcb-group-checkbox-active-color').set(controlValue);
			wp.customize('rcb-banner-footer-design-bg').set(controlValue);
			if(rcbcs_acceptAllIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-all-font-color').set(controlValue);
				wp.customize('rcb-banner-body-design-btn-accept-all-hover-font-color').set(controlValue);
			}
		});
	});

	// Primary font color
	wp.customize('rcbcs-primary-font-color', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-group-headline-color').set(controlValue);
			wp.customize('rcb-banner-body-design-btn-accept-individual-hover-font-color').set(controlValue);
			wp.customize('rcb-banner-header-design-font-color').set(controlValue);
			wp.customize('rcb-banner-design-font-color').set(controlValue);
			if(rcbcs_acceptEssentialsIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-essentials-font-color').set(controlValue);
				wp.customize('rcb-banner-body-design-btn-accept-essentials-hover-font-color').set(controlValue);
			}
			if(rcbcs_acceptIndividualIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-individual-font-color').set(controlValue);
				wp.customize('rcb-banner-body-design-btn-accept-individual-hover-font-color').set(controlValue);
			}
			if(rcbcs_saveIsButton) {
				wp.customize('rcb-save-button-font-color').set(controlValue);
				wp.customize('rcb-save-button-hover-font-color').set(controlValue);
			}
		});
	});

	// Secondary font color
	wp.customize('rcbcs-secondary-font-color', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-group-desc-color').set(controlValue);
			wp.customize('rcb-banner-body-design-teachings-font-color').set(controlValue);
		});
	});

	// Link color
	wp.customize('rcbcs-link-color', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-banner-footer-design-font-color').set(controlValue);
			wp.customize('rcb-group-link-color').set(controlValue);
			if(!rcbcs_acceptEssentialsIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-essentials-font-color').set(controlValue);
			}
			if(!rcbcs_acceptIndividualIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-individual-font-color').set(controlValue);
			}
			if(!rcbcs_saveIsButton) {
				wp.customize('rcb-save-button-font-color').set(controlValue);
			}
		});
	});

	// Link color hover
	wp.customize('rcbcs-link-color-hover', function(control) {
		control.bind(function(controlValue) {
			wp.customize('rcb-banner-footer-design-hover-font-color').set(controlValue);
			wp.customize('rcb-group-link-hover-color').set(controlValue);
			if(!rcbcs_acceptEssentialsIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-essentials-hover-font-color').set(controlValue);
			}
			if(!rcbcs_acceptIndividualIsButton) {
				wp.customize('rcb-banner-body-design-btn-accept-individual-hover-font-color').set(controlValue);
			}
			if(!rcbcs_saveIsButton) {
				wp.customize('rcb-save-button-hover-font-color').set(controlValue);
			}
		});
	});

});
