import { toolbar, reports} from "./rbac-consts";

const rules = {
  ROLE_ADMIN: {
    static: [
      toolbar.ADMIN,
      reports.ADMIN
    ],
    dynamic: {}
  },

};

export default rules;