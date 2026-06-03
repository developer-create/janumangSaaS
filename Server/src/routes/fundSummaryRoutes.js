const express = require("express");
const fundSummaryController = require("../controllers/fundSummaryController");
const protect = require("../middleware/authMiddleware");
const { checkModuleAccess } = require("../middleware/moduleAccessMiddleware");

const router = express.Router();

router.use(protect);
router.use(checkModuleAccess("projects"));

router
  .route("/stats")
  .get(
    fundSummaryController.getFundSummaryStats
  );

router
  .route("/list")
  .get(
    fundSummaryController.getFundSummaryList
  );

module.exports = router;
