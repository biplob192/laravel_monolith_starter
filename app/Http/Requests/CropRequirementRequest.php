<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CropRequirementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store()
    {
        return [
            'crop'                      => 'required|integer',
            'soil_type'                 => 'required|integer',
            'sections.*.growth_stage'    => 'required|integer',
            'sections.*.water'          => 'required',
            'sections.*.nitrogen'       => 'required',
            'sections.*.potassium'      => 'required',
            'sections.*.phosphorus'     => 'required',
        ];
    }

    protected function update()
    {
        // Extract values from the input data
        $cropId = $this->input('crop_id');
        $soilTypeId = $this->input('soil_type_id');
        $growthStageId = $this->input('growth_stage_id');

        return [
            'crop_id' => 'required',
            'soil_type_id' => 'required',
            'growth_stage_id' => [
                'required',
                Rule::unique('crop_requirements')
                    ->ignore($this->route('id'))
                    ->where(function ($query) use ($cropId, $soilTypeId, $growthStageId) {
                        return $query->where('crop_id', $cropId)
                            ->where('soil_type_id', $soilTypeId)
                            ->where('growth_stage_id', $growthStageId);
                    }),
            ],
            'water' => 'required',
            'nitrogen' => 'required',
            'potassium' => 'required',
            'phosphorus' => 'required',
        ];
    }
}
