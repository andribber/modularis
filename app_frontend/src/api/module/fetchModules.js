import axios from 'axios';

export default async function(tenant_id) {
  const url_params = new URLSearchParams({ include: 'users' });

  const { data } = await axios.get(`tenants/${tenant_id}/modules`, { params: url_params });

  return data;
}
