import axios from 'axios';

export default async function(tenant_id, module, body) {
  const { data } = await axios.post(`tenants/${tenant_id}/modules/${module}/execute`, body);

  return data;
}
