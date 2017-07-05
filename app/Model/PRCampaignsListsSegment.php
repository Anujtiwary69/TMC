<?php

namespace Acelle\Model;

use Illuminate\Database\Eloquent\Model;

class PRCampaignsListsSegment extends Model
{
    /**
     * Associations.
     *
     * @var object | collect
     */
    public function campaign()
    {
        return $this->belongsTo('Acelle\Model\PRCampaign');
    }
    
    public function mailList()
    {
        return $this->belongsTo('Acelle\Model\PRList');
    }
    
    public function segment()
    {
        return $this->belongsTo('Acelle\Model\PRSegment');
    }
    
    /**
     * Get segment in the same campaign and mail list
     *
     * @return collect
     */
    public function getRelatedSegments()
    {
        $segments = PRSegment::leftJoin('p_r_campaigns_lists_segments', 'p_r_campaigns_lists_segments.p_r_segment_id', '=', 'p_r_segments.id')
                        ->where('p_r_campaigns_lists_segments.p_r_campaign_id', '=', $this->p_r_campaign_id)
                        ->where('p_r_campaigns_lists_segments.p_r_list_id', '=', $this->p_r_list_id);
        
        return $segments->get();
    }
}
