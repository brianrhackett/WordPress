var applyNowSalesforce = {

	campusSelector: '#input_' + scriptData.gfSfId + '_18',

	cohortSelector: '#input_' + scriptData.gfSfId + '_81',

	programSelector: '#input_' + scriptData.gfSfId + '_17',

	noCohortsText: 'No active Cohorts',

	formId: scriptData.gfSfId,

	/**
	 * Initilizaiton
	 */
	init: function() {
		if ( applyNowSalesforce.hasForm() ) {

			$( applyNowSalesforce.cohortSelector ).selectBoxIt({ downArrowIcon: 'down-arrow' });
			$( document ).on( 'gform_post_render', function( event, formId, currentPageInteger ) {
				if ( formId == applyNowSalesforce.formId && currentPageInteger == 1 ) {
					applyNowSalesforce.populateCohorts();
				}
			});

			$( document ).on( 'change',
				applyNowSalesforce.campusSelector +
				', ' +
				applyNowSalesforce.programSelector,
				applyNowSalesforce.populateCohorts
			);
		}
	},

	/**
	 * Check if this page has the apply-now-salesforce form on it
	 *
	 */
	hasForm: function() {
		var $form = $( '#gform_' + applyNowSalesforce.formId );
		if ( $form.length ) {
			return true;
		} else {
			return false;
		}
	},

	/**
	 * Populates the cohorts dropdown based on the selected value of the selected campus
	 */
	populateCohorts: function() {
		var jsonData = null,
			$campusSelect = $( applyNowSalesforce.campusSelector ),
			$cohortSelect = $( applyNowSalesforce.cohortSelector ),
			$programSelect = $( applyNowSalesforce.programSelector ),
			selectedCohort = $cohortSelect.find( 'option:selected' ).val();

		$( applyNowSalesforce.cohortSelector ).selectBoxIt({ downArrowIcon: 'down-arrow' });

		try {
			jsonData = JSON.parse( $( '#js-ans-cohort-data' ).html() );
		} catch ( e ) {
			return false;
		}

		if (
			jsonData &&
			$campusSelect.length &&
			$cohortSelect.length &&
			$programSelect.length
		) {

			var options = '',
				selectedCampusValue = $campusSelect.find( 'option:selected' ).val(),
				selectedProgramValue = $programSelect.find( 'option:selected' ).val(),
				activeCohorts = [];

			for ( var i in jsonData ) {
				var dateArr = jsonData[i].start_date.split( '-' ),
					cohortStartDate = new Date(
						parseInt( dateArr[0]),
						parseInt( dateArr[1] - 1 ),
						parseInt( dateArr[2])
					),
					currentDate = new Date();

				cohortStartDate.setHours( 0, 0, 0, 0 );
				cohortStartDate = cohortStartDate.getTime();
				currentDate = currentDate.getTime();
				if (
					jsonData[i].program_name == selectedProgramValue &&
					jsonData[i].campus_id == selectedCampusValue &&
					cohortStartDate > currentDate
				) {
					activeCohorts.push( jsonData[i]);
				}
			}

			if ( activeCohorts.length > 0 ) {
				if ( selectedCohort ) {
					options += '<option value="">' + $cohortSelect.attr( 'data-default-option-text' ) + '</option>\n';

					for ( var ii in activeCohorts ) {
						if ( selectedCohort === activeCohorts[ii].id ) {
							options += '<option selected="selected" value="' + activeCohorts[ii].id + '">' + activeCohorts[ii].label + '</option>\n';
						} else {
							options += '<option value="' + activeCohorts[ii].id + '">' + activeCohorts[ii].label + '</option>\n';
						}
					}
				} else {
					options += '<option value="" selected="selected">' + $cohortSelect.attr( 'data-default-option-text' ) + '</option>\n';
					for ( var iii in activeCohorts ) {
						options += '<option value="' + activeCohorts[iii].id + '">' + activeCohorts[iii].label + '</option>\n';
					}
				}

			} else {
				options = '<option value="" value="" selected="selected">' + applyNowSalesforce.noCohortsText + '</option>\n';
			}

			$( applyNowSalesforce.cohortSelector ).html( options );
		}
		var $selectBoxIt = $( applyNowSalesforce.cohortSelector ).data( 'selectBox-selectBoxIt' );
		if ( typeof $selectBoxIt != 'undefined' ) {
			$selectBoxIt.refresh();
		}
	}
};

module.exports = applyNowSalesforce.init();
