import axios from 'axios';

export default async function(tenant_id, module) {
  await axios.post(`tenants/${tenant_id}/modules/contract`, { name: module });
}
