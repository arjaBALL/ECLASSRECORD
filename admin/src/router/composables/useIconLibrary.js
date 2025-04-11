/** @format */

import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faBars,
  faBell,
  faIdCard,
  faFileAlt,
  faUserGraduate,
  faTools,
  faUsersCog,
  faGear,
  faExchangeAlt,
  faFolderTree,
  faRightFromBracket,
  faAngleDown,
  faUserPlus,
  faSave,
  faEdit,
  faTrash,
  faSync,
  faDoorOpen,
  faBuilding,
  faSitemap,
  faTachometerAlt, // Added this icon which was in the original menuItems
  faClipboardCheck, // Added this icon which was in the original menuItems
  faEye,
  faFileLines,
  faF,
} from "@fortawesome/free-solid-svg-icons";

export function useIconLibrary() {
  // Add all icons to the library in one call
  library.add(
    faBars,
    faBell,
    faIdCard,
    faFileAlt,
    faUserGraduate,
    faTools,
    faUsersCog,
    faGear,
    faExchangeAlt,
    faFolderTree,
    faRightFromBracket,
    faAngleDown,
    faUserPlus,
    faSave,
    faEdit,
    faTrash,
    faSync,
    faDoorOpen,
    faBuilding,
    faSitemap,
    faTachometerAlt,
    faClipboardCheck,
    faEye,
    faF
  );

  return { library };
}
