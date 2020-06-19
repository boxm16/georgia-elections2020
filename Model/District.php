<?php


class District {
   private $districtId;
   private $districtFullName;
   private $districtCandidates;
   
   public function getDistrictId() {
       return $this->districtId;
   }

   public function getDistrictFullName() {
       return $this->districtFullName;
   }

   public function getDistrictCandidates() {
       return $this->districtCandidates;
   }

   public function setDistrictId($districtId) {
       $this->districtId = $districtId;
   }

   public function setDistrictFullName($districtFullName) {
       $this->districtFullName = $districtFullName;
   }

   public function setDistrictCandidates($districtCandidates) {
       $this->districtCandidates = $districtCandidates;
   }


}
