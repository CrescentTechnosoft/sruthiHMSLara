<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Advance
 *
 * @property int $id
 * @property int|null $ip_id
 * @property int|null $pt_id
 * @property int|null $advance_no
 * @property string|null $amount
 * @property string|null $pay_type
 * @property string|null $other_pay_type
 * @property string|null $card_no
 * @property string|null $card_type
 * @property string|null $card_expiry
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\IPAdmission|null $admission
 * @property-read \App\Models\Registration|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder|Advance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereAdvanceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereCardExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereOtherPayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advance whereUserId($value)
 */
	class Advance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Appointment
 *
 * @property int $id
 * @property int|null $pt_id
 * @property string|null $name
 * @property string|null $contact_no
 * @property int|null $doctor_id
 * @property string|null $appointment_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereAppointmentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 */
	class Appointment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CardType
 *
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|CardType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CardType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CardType query()
 * @method static \Illuminate\Database\Eloquent\Builder|CardType whereName($value)
 */
	class CardType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Complaint
 *
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint query()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereName($value)
 */
	class Complaint extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Department
 *
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @mixin \Eloquent
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Doctor
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $age
 * @property string|null $gender
 * @property string|null $contact_no
 * @property string|null $email_address
 * @property string|null $address
 * @property string|null $specialization
 * @property string|null $qualification
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DoctorTiming[] $timings
 * @property-read int|null $timings_count
 * @method static \Database\Factories\DoctorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereQualification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor whereUpdatedAt($value)
 */
	class Doctor extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DoctorTiming
 *
 * @property int $doctor_id
 * @property string|null $day
 * @property string|null $start
 * @property string|null $end
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming query()
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DoctorTiming whereStart($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Doctor $doctor
 */
	class DoctorTiming extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Fee
 *
 * @property int $id
 * @property string|null $department
 * @property string|null $category
 * @property string|null $name
 * @property string|null $op_cost
 * @property string|null $ip_cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Fee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereIpCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereOpCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereUpdatedAt($value)
 */
	class Fee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GroupTest
 *
 * @property int $id
 * @property string|null $category
 * @property string|null $name
 * @property float|null $fees
 * @property array|null $test_fields
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest whereTestFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupTest whereUpdatedAt($value)
 */
	class GroupTest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IPAdmission
 *
 * @property int $id
 * @property string|null $year
 * @property int|null $ip_no
 * @property int|null $pt_id
 * @property string|null $fees
 * @property string|null $advance
 * @property string|null $type
 * @property string|null $diagnosis
 * @property string|null $department
 * @property int|null $consultant
 * @property int|null $referrer
 * @property string|null $rel_name
 * @property string|null $rel_contact_no
 * @property string|null $rel_type
 * @property string|null $rel_address
 * @property string|null $ins_cat
 * @property string|null $ins_id
 * @property string|null $ins_name
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\IPBill|null $billing
 * @property-read \App\Models\IPDischarge|null $discharge
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\Registration|null $patient
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IPTreatment[] $treatments
 * @property-read int|null $treatments_count
 * @property-read \App\Models\Ward|null $ward
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereAdvance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereConsultant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereInsCat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereInsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereInsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereIpNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereReferrer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereRelAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereRelContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereRelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereRelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPAdmission whereYear($value)
 */
	class IPAdmission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IPBill
 *
 * @property int $id
 * @property string|null $year
 * @property int|null $bill_no
 * @property int|null $pt_id
 * @property int|null $ip_id
 * @property string|null $total
 * @property string|null $advance_paid
 * @property string|null $discount
 * @property string|null $sub_total
 * @property string|null $paid
 * @property string|null $due
 * @property string|null $refund
 * @property string|null $payment_method
 * @property string|null $other_payment
 * @property string|null $card_no
 * @property string|null $card_type
 * @property string|null $card_expiry
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\IPAdmission|null $admission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IPBillDetail[] $billDetails
 * @property-read int|null $bill_details_count
 * @property-read \App\Models\IPDischarge|null $discharge
 * @property-read \App\Models\Registration|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereAdvancePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereBillNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereCardExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereOtherPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBill whereYear($value)
 */
	class IPBill extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IPBillDetail
 *
 * @property int|null $bill_id
 * @property int $ip_id
 * @property int|null $pt_id
 * @property string|null $department
 * @property string|null $category
 * @property int|null $fees_id
 * @property string|null $fees_type
 * @property string|null $cost
 * @property string|null $discount
 * @property int|null $qty
 * @property string|null $total
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereFeesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereFeesType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPBillDetail whereTotal($value)
 */
	class IPBillDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IPDischarge
 *
 * @property int $id
 * @property int|null $ip_id
 * @property int|null $pt_id
 * @property string|null $history
 * @property string|null $diagnosis
 * @property string|null $investigations
 * @property string|null $surgery
 * @property string|null $treatment
 * @property string|null $advice
 * @property string|null $condition
 * @property string|null $disease
 * @property string|null $consultants
 * @property string|null $death_date
 * @property string|null $death_details
 * @property string|null $hosp_course
 * @property string|null $report
 * @property string|null $pt_reaction
 * @property string|null $pulse
 * @property string|null $bp
 * @property string|null $hb
 * @property string|null $tc
 * @property string|null $wbc
 * @property string|null $poly
 * @property string|null $lymp
 * @property string|null $eos
 * @property string|null $m
 * @property string|null $b
 * @property string|null $blood_sugar
 * @property string|null $urea
 * @property string|null $scr
 * @property string|null $crit
 * @property string|null $plat
 * @property int|null $user_id
 * @property string|null $admitted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\IPAdmission|null $admission
 * @property-read \App\Models\Registration|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereAdmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereAdvice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereBloodSugar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereBp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereConsultants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereCrit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereDeathDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereDeathDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereDisease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereEos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereHb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereHospCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereInvestigations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereLymp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge wherePlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge wherePoly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge wherePtReaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereScr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereSurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereTc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereTreatment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereUrea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPDischarge whereWbc($value)
 */
	class IPDischarge extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IPLabResult
 *
 * @property int|null $treatment_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $ip_id
 * @property int|null $pt_id
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResult wherePtId($value)
 */
	class IPLabResult extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IPLabResultDetail
 *
 * @property int|null $treatment_id
 * @property int|null $test_id
 * @property int|null $field_id
 * @property string|null $result
 * @property string|null $result_type
 * @property bool|null $is_selected
 * @property int|null $alignment
 * @property bool|null $is_group
 * @property-read \App\Models\Test|null $test
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail whereAlignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail whereIsGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail whereIsSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail whereResultType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPLabResultDetail whereTreatmentId($value)
 */
	class IPLabResultDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IPTreatment
 *
 * @property int $id
 * @property int|null $ip_id
 * @property int|null $pt_id
 * @property int|null $ref_no
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\IPAdmission|null $admission
 * @property-read \App\Models\Registration|null $patient
 * @property-read \App\Models\IPLabResult|null $result
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IPTreatmentDetails[] $treatments
 * @property-read int|null $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment whereRefNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatment whereUserId($value)
 */
	class IPTreatment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IPTreatmentDetails
 *
 * @property int|null $treatment_id
 * @property int|null $ip_id
 * @property int|null $pt_id
 * @property int|null $s_no
 * @property int|null $fees_id
 * @property string|null $department
 * @property string|null $category
 * @property string|null $fees_type
 * @property string|null $test_type
 * @property int|null $qty
 * @property float|null $cost
 * @property float|null $total
 * @property-read \App\Models\IPAdmission|null $admission
 * @property-read \App\Models\Registration|null $patient
 * @property-read \App\Models\IPTreatment|null $treatment
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereFeesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereFeesType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereSNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereTestType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IPTreatmentDetails whereTreatmentId($value)
 */
	class IPTreatmentDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InsuranceCategory
 *
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceCategory whereName($value)
 * @mixin \Eloquent
 */
	class InsuranceCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Medicine
 *
 * @property int $id
 * @property string|null $medicine_name
 * @property string|null $company
 * @property string|null $medicine_type
 * @property string|null $hsn_code
 * @property string|null $schedule
 * @property int|null $reorder_level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine query()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereHsnCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereMedicineName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereMedicineType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereReorderLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicine whereUpdatedAt($value)
 */
	class Medicine extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OPBill
 *
 * @property int $id
 * @property string|null $year
 * @property int|null $bill_no
 * @property int|null $pt_id
 * @property int|null $doctor_id
 * @property float|null $total
 * @property string|null $discount
 * @property string|null $sub_total
 * @property string|null $paid
 * @property string|null $due
 * @property string|null $refund
 * @property string|null $payment_method
 * @property string|null $other_payment
 * @property string|null $card_no
 * @property string|null $card_type
 * @property string|null $card_expiry
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OPBillDetail[] $billDetails
 * @property-read int|null $bill_details_count
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\Registration|null $patient
 * @property-read \App\Models\Registration|null $registration
 * @property-read \App\Models\OpLabResult|null $result
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill query()
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereBillNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereCardExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereOtherPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBill whereYear($value)
 */
	class OPBill extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OPBillDetail
 *
 * @property int|null $bill_id
 * @property int|null $pt_id
 * @property string|null $department
 * @property string|null $category
 * @property int|null $fees_id
 * @property string|null $fees_type
 * @property string|null $test_type Column to Identify Whether it is a single test or Group Test or Profile on Lab Result
 * @property float|null $fees
 * @property string|null $discount
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail whereFeesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail whereFeesType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPBillDetail whereTestType($value)
 */
	class OPBillDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OPRegistration.
 *
 * @property int                             $id
 * @property string|null                     $year
 * @property int|null                        $op_no
 * @property int|null                        $pt_id
 * @property string|null                     $name
 * @property string|null                     $age
 * @property string|null                     $gender
 * @property string|null                     $contact_no
 * @property int|null                        $doctor_id
 * @property string|null                     $height
 * @property string|null                     $weight
 * @property string|null                     $bsa
 * @property string|null                     $bp
 * @property string|null                     $pulse
 * @property string|null                     $status
 * @property string|null                     $visit_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration query()
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereBp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereBsa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereOpNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration wherePulse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereVisitReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OPRegistration whereYear($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\Prescription|null $prescription
 */
	class OPRegistration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OpLabResult
 *
 * @property int $id
 * @property int|null $bill_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResult whereUserId($value)
 */
	class OpLabResult extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OpLabResultDetails
 *
 * @property int|null $bill_id
 * @property int|null $test_id
 * @property int|null $field_id
 * @property string|null $result
 * @property string|null $result_type
 * @property bool|null $is_selected
 * @property int|null $alignment
 * @property bool|null $is_group
 * @property-read \App\Models\Test|null $test
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails whereAlignment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails whereIsGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails whereIsSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails whereResultType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OpLabResultDetails whereTestId($value)
 */
	class OpLabResultDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentType.
 *
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentType whereName($value)
 * @mixin \Eloquent
 */
	class PaymentType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Prescription
 *
 * @property int $id
 * @property int|null $op_id
 * @property string|null $year
 * @property int|null $op_no
 * @property string|null $opinion
 * @property string|null $patient_info
 * @property string|null $diagnosis
 * @property mixed|null $complaints
 * @property mixed|null $medicines
 * @property mixed|null $investigations
 * @property mixed|null $treatments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OPRegistration|null $opReg
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereComplaints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereInvestigations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereMedicines($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereOpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereOpNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereOpinion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription wherePatientInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereTreatments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereYear($value)
 */
	class Prescription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Profile
 *
 * @property int $id
 * @property string|null $name
 * @property array|null $tests
 * @property string|null $fees
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereTests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 */
	class Profile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Registration
 *
 * @property int $id
 * @property string|null $uuid
 * @property string|null $salutation
 * @property string|null $name
 * @property string|null $age
 * @property string|null $gender
 * @property string|null $dob
 * @property string|null $contact_no
 * @property string|null $email_address
 * @property string|null $address
 * @property int|null $doctor_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor|null $doctor
 * @method static \Database\Factories\RegistrationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Registration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Registration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Registration whereUuid($value)
 */
	class Registration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Specialization
 *
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|Specialization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialization whereName($value)
 * @mixin \Eloquent
 */
	class Specialization extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Test
 *
 * @property int $id
 * @property string|null $category
 * @property string|null $name
 * @property string|null $method
 * @property string|null $sample
 * @property string|null $units
 * @property string|null $reference_range
 * @property string|null $comments
 * @property string|null $parameters
 * @property float|null $fees
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereReferenceRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereSample($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereUpdatedAt($value)
 */
	class Test extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TestCategory
 *
 * @property int $id
 * @property string|null $Category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|TestCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TestCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TestCategory withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $category
 */
	class TestCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TestDetails
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TestDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestDetails query()
 */
	class TestDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Test.
 *
 * @property string|null $category
 * @property string|null $name
 * @property string|null $field_category
 * @property string|null $field_name
 * @property string|null $method
 * @property string|null $sample
 * @property string|null $reference_range
 * @property string|null $comments
 * @property string|null $cost
 * @property string|null $out_cost
 * @method static \Illuminate\Database\Eloquent\Builder|Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereFieldCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereOutCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereReferenceRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereSample($value)
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $units
 * @property string|null $parameters
 * @property string|null $fees
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TestDetails[] $testDetails
 * @property-read int|null $test_details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Test_old whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test_old whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test_old whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test_old whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test_old whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test_old whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test_old whereUpdatedAt($value)
 */
	class Test_old extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Treatment
 *
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereName($value)
 */
	class Treatment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $login_name
 * @property string|null $password
 * @property string|null $access
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLoginName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ward
 *
 * @property int $id
 * @property string|null $floor
 * @property string|null $ward
 * @property string|null $room
 * @property string|null $bed
 * @property float|null $rent
 * @property int|null $ip_id
 * @property int|null $pt_id
 * @property string|null $name
 * @property bool|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\IPAdmission|null $admission
 * @property-read \App\Models\Registration|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder|Ward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ward query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereBed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward wherePtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ward whereWard($value)
 */
	class Ward extends \Eloquent {}
}

