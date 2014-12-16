<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template name="EditField">
        <xsl:param name="field"/>
        <xsl:param name="value"/>
        
        <div class="edit-field">
            <div class="label">
                <xsl:value-of select="$field/title"/>
            </div>
            <div class="value">
                <xsl:choose>
                    <xsl:when test="$field/type = 'text'">
                        <textarea name="{$field/name}"><xsl:value-of select="$value"/></textarea>
                    </xsl:when>
                    <xsl:otherwise>
                        <input type="text" name="{$field/name}" value="{$value}"/>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
